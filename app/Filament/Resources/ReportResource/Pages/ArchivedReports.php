<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder; // Ensure to import the correct Builder

class ArchivedReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    public static function getPages(): array
    {
        return [
            'index' => static::route('/'),
            'archived' => static::route('/archived'), // Define the route for archived reports
        ];
    }

    protected function getTableQuery(): Builder // Correct return type
    {
        return parent::getTableQuery()->where('archived', true); // Adjust query to only show archived reports
    }
}
