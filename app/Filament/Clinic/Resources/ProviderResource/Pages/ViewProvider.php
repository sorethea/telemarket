<?php

namespace App\Filament\Clinic\Resources\ProviderResource\Pages;

use App\Filament\Clinic\Resources\ProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProvider extends ViewRecord
{
    protected static string $resource = ProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
