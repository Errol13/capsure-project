<?php

namespace App\Filament\Resources\Profile\VerificationResource\Pages;

use App\Filament\Resources\Profile\VerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVerifications extends ListRecords
{
    protected static string $resource = VerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
