<?php

namespace App\Filament\Resources\ValidationResource\Pages;

use App\Filament\Resources\ValidationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidations extends ListRecords
{
    protected static string $resource = ValidationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
