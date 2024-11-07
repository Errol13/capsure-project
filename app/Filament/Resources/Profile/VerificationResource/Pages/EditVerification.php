<?php

namespace App\Filament\Resources\Profile\VerificationResource\Pages;

use App\Filament\Resources\Profile\VerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVerification extends EditRecord
{
    protected static string $resource = VerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
