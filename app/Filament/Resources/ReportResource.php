<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\Pages\ShowArchivedReports;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Jobs\ArchiveReportJob;
use App\Models\Profile\Report;
use App\Models\Profile\Suspension;
use Carbon\Carbon;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-s-exclamation-triangle';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Report::query()->with(['reportedUser', 'reporterUser']) // Eager load the related user
                    ->join('users', 'reports.reported_user_id', '=', 'users.id')->where('isArchived', false)
                    ->select('reports.*')
            )
            ->headerActions([
                Action::make('seeArchive')
                    ->label('See Archive')
                    ->url(route('filament.admin.resources.reports.showArchivedReports'))
                    ->color('primary')
                    ->extraAttributes(['class' => 'ml-auto']),
            ])
            ->columns([
                TextColumn::make('reportedUser.id')->label('User ID'),
                // TextColumn::make('id')->label('Report Id')
                //     ->getStateUsing(fn($record) => $record->id)
                //     ->sortable(),
                TextColumn::make('userFullNameAndEmail')
                    ->label('Reported User')
                    ->getStateUsing(fn($record) => $record->reportedUser->first_name . ' ' . $record->reportedUser->last_name)
                    ->description(fn($record): string => $record->reportedUser->email)
                    ->searchable(['users.first_name', 'users.last_name']),
                // TextColumn::make('status')
                // ->label('Status')
                // ->getStateUsing(fn($record) => $record->reportedUser->isSuspended() ? 'Suspended' : 'Not Suspended')
                // ->color((fn($record) => $record->reportedUser->isSuspended() ? 'warning' : 'info')),
                TextColumn::make('reportedUser')
                    ->label('Time Remaining')
                    ->getStateUsing(function ($record) {
                        $suspension = $record->reportedUser->suspension;

                        // Check if the user has a suspension with an end date
                        if ($suspension && $suspension->end_at) {
                            // Parse end date and set timezone to Asia/Manila
                            $endDate = Carbon::parse($suspension->end_at)->timezone('Asia/Manila');
                            $now = Carbon::now('Asia/Manila');

                            // Calculate the remaining time
                            if ($endDate->isFuture()) {
                                // Calculate the difference and return human-readable format
                                $diff = $now->diffForHumans($endDate, true);
                                return $diff; // e.g., "2 days", "3 hours", etc.
                            } else {
                                return 'Suspension Ended'; // Suspension has ended
                            }
                        } else {
                            return 'No Suspension'; // Indicate no suspension
                        }
                    })
                    ->html(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('viewReport')
                    ->label('View Report')
                    ->modalHeading('')
                    ->modalDescription('This contains the full details of the report.')
                    ->modalContent(fn($record) => view('components.filament_use.viewReport-modal', ['record' => $record]))
                    ->modalCancelAction(fn(StaticAction $action) => $action->label('Close')->extraAttributes(['class' => 'ml-auto']))
                    ->color('primary')
                    ->modalSubmitAction(false)
                    ->modalWidth('lg')
                    ->requiresConfirmation(false),
                Action::make('suspend')
                    ->label(fn($record) => $record->reportedUser->isSuspended() ? 'Lift Suspension' : 'Suspend')
                    ->modalHeading(fn($record) => $record->reportedUser->isSuspended() ? 'Lift Suspension' : 'Suspend User')
                    ->form(function ($record) {
                        $user = $record->reportedUser;

                        // Common fields (name and ID)
                        $form = [
                            Grid::make(2) // Defines a 2-column grid
                                ->schema([
                                    Placeholder::make('user_name')
                                        ->label('Reported User')
                                        ->content("{$user->first_name} {$user->last_name}"),
                                    Placeholder::make('user_id')
                                        ->label('User ID')
                                        ->content($user->id),
                                ]),
                        ];

                        // Add the suspension duration field if the user is not already suspended
                        if (!$user->isSuspended()) {
                            $form[] = Select::make('duration')
                                ->label('Suspension Duration')
                                ->options([
                                    60 => '1 Hour',
                                    1440 => '1 Day',
                                    4320 => '3 Days',
                                    21600 => '15 Days',
                                ])
                                ->required();
                        }

                        return $form;
                    })
                    ->action(function ($record, $data) {

                        // Ensure data is wrapped in an array if it's not already
                        if (!is_array($data)) {
                            $data = ['duration' => $data];  // Wrap it in an array
                        }

                        if ($record->reportedUser->isSuspended()) {
                            // Call the lift suspension method
                            self::liftSuspension($record);
                        } else if (isset($data['duration'])) {
                            // Apply suspension with specified duration
                            self::suspendUser($record, $data); // Pass the array
                        }
                    })
                    ->color(fn($record) => $record->reportedUser->isSuspended() ? 'danger' : 'warning')
                    ->requiresConfirmation()
                    ->modalDescription(
                        fn($record) => $record->reportedUser->isSuspended()
                            ? 'Are you sure you want to lift the suspension? The user will regain access immediately.'
                            : 'Please select a suspension duration. The user will be suspended for the specified time.'
                    )
                    ->modalSubmitActionLabel(fn($record) => $record->reportedUser->isSuspended()
                        ? 'Confirm' : 'Suspend')
                    ->visible(fn($record) => !$record->isArchived),

                Action::make('archive')
                    ->label('Archive')
                    ->color('info')
                    ->action(fn(Report $record) => static::archiveReport($record))
                    ->requiresConfirmation()
                    ->modalHeading('Are you sure you want to archive this report?')
                    ->modalSubmitActionLabel('Archive')
                    ->modalDescription(''),
            ])
            ->poll('10s')
            ->bulkActions([
                //
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('isArchived', false)->count();

        return $count > 0 ? (string) $count : null;
    }


    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getActions(): array
    {
        return [
            //
        ];
    }

    // Method to suspend a user and set up automatic report archiving
    public static function suspendUser(Report $record, array $data)
    {
        $suspension = Suspension::firstOrNew(['user_id' => $record->reportedUser->id]);

        // Apply suspension with selected duration
        $duration = isset($data['duration']) && is_numeric($data['duration']) ? (int) $data['duration'] : 1;  // Default to 1 minute if invalid
        $suspension->isSuspended = true;
        $suspension->start_at = Carbon::now();
        $suspension->end_at = Carbon::now()->addMinutes($duration);
        $suspension->suspended_reason = $record->reason;


        // dd('end date sus:', $suspension->end_date->format('Y-m-d H:i:s')); 
        // dd('isSuspended:', $suspension->isSuspended); 
        $suspension->save();

        // Schedule to automatically archive the report when suspension ends
        self::scheduleArchiving($record, $suspension->end_at);
    }

    // Method to lift suspension and automatically archive the report
    public static function liftSuspension(Report $record)
    {
        $suspension = Suspension::where('user_id', $record->reportedUser->id)->first();

        if ($suspension) {
            $suspension->isSuspended = false;
            $suspension->start_at = null;
            $suspension->end_at = null;
            $suspension->suspended_reason = null;
            $suspension->save();

            //dd($record->id);
            // Archive the report upon lifting suspension if not already archived
            if (!$record->isArchived) {
                self::archiveReport($record);
            }
        }
    }

    // Method to archive a report
    public static function archiveReport(Report $record)
    {
        $record->isArchived = true;
        $record->save();
    }

    // Helper method to schedule report archiving
    private static function scheduleArchiving(Report $record, Carbon $endDate)
    {

        //dd($record->id); 
        // Dispatch the job with a delay until the suspension end date
        $endDate = Carbon::parse($endDate); // Ensure $endDate is a Carbon instance

        // Create the job instance and set the delay
        $job = new ArchiveReportJob($record->id);
        $job->delay($endDate); // Delay until the $endDate

        // Dispatch the job with the delay
        dispatch($job);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            // 'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
            'showArchivedReports' => ShowArchivedReports::route('/archived'),
        ];
    }
}
