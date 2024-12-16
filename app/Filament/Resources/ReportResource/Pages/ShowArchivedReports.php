<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\Profile\Report;
use Filament\Actions\StaticAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ShowArchivedReports extends Page implements HasTable
{

    use InteractsWithTable;

    protected static string $resource = ReportResource::class;

    protected static ?string $model = Report::class;

    protected static string $view = 'filament.resources.report-resource.pages.show-archived-reports';

    public static function getPages(): array
    {
        return [
            'index' => ListReports::route('/'),
            'showArchivedReports' => ShowArchivedReports::route('/archived'),
        ];
    }

    /**
     * The table definition for the page.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Report::query()
                    ->with(['reportedUser', 'reporterUser']) // Eager load the related users
                    ->where('isArchived', true)
            )
            ->columns([
                // Define your table columns
                TextColumn::make('reportedUser.id')
                    ->label('User ID'),
                
                TextColumn::make('id')
                    ->label('Report ID')
                    ->getStateUsing(fn($record) => $record->id)
                    ->sortable(),
                
                TextColumn::make('userFullNameAndEmail')
                    ->label('Reported User')
                    ->getStateUsing(fn($record) => $record->reportedUser->first_name . ' ' . $record->reportedUser->last_name)
                    ->description(fn($record): string => $record->reportedUser->email)
                    ->searchable(['users.first_name', 'users.last_name']),
            ])
            ->filters([])  
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
            ])  
            ->bulkActions([]);
    }
}
