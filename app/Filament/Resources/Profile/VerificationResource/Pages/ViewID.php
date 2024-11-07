<?php

namespace App\Filament\Resources\Profile\VerificationResource\Pages;

use App\Filament\Resources\Profile\VerificationResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ViewID extends Page
{
    use InteractsWithRecord;

    protected static string $resource = VerificationResource::class;

    protected static string $view = 'filament.resources.profile.verification-resource.pages.view-i-d';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
