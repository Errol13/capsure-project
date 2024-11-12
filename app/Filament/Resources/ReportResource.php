<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Profile\Report;
use App\Models\Profile\Suspension;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-s-exclamation-triangle';

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
                Report::query()->with('reportedUser') // Eager load the related user
                ->join('users', 'reports.reported_user_id', '=', 'users.id')
            )
            ->columns([
                TextColumn::make('reportedUser.id')->label('User ID'),
                TextColumn::make('userFullNameAndEmail')
                    ->label('User')
                    ->getStateUsing(fn($record) => $record->reportedUser->first_name . ' ' . $record->reportedUser->last_name)
                    ->description(fn($record): string => $record->reportedUser->email)
                    ->searchable(['users.first_name', 'users.last_name']),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('suspend')
                    ->label(fn($record) => $record->reportedUser->isSuspended() ? 'Lift Suspension' : 'Suspend')
                    ->modalHeading(fn($record) => $record->reportedUser->isSuspended() ? 'Lift Suspension' : 'Suspend User')
                    ->form(function ($record) {
                        return $record->reportedUser->isSuspended() ? [] : [
                            Forms\Components\TextInput::make('duration')
                                ->label('Suspension Duration (Days)')
                                ->required()
                                ->numeric()
                                ->minValue(1),
                        ];
                    })
                    ->action(function ($record, array $data) {
                        $suspension = Suspension::firstOrNew(['user_id' => $record->id]);

                        if ($suspension->isSuspended) {
                            // Lift the suspension
                            $suspension->isSuspended = false;
                            $suspension->start_date = null;
                            $suspension->end_date = null;
                        } else {
                            // Apply suspension
                            $duration = $data['duration'] ?? 1;
                            $suspension->isSuspended = true;
                            $suspension->start_date = Carbon::now();
                            $suspension->end_date = Carbon::now()->addDays($duration);
                        }

                        $suspension->save();
                    })
                    ->color(fn($record) => $record->reportedUser->isSuspended() ? 'danger' : 'warning')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
            'archived' => Pages\ArchivedReports::route('/archived'),
        ];
    }
}
