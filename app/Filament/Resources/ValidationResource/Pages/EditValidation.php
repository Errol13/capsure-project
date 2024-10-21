<?php

namespace App\Filament\Resources\ValidationResource\Pages;

use App\Filament\Resources\ValidationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidation extends EditRecord
{
    protected static string $resource = ValidationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
