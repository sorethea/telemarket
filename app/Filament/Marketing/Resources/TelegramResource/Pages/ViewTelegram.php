<?php

namespace App\Filament\Marketing\Resources\TelegramResource\Pages;

use App\Filament\Marketing\Resources\TelegramResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTelegram extends ViewRecord
{
    protected static string $resource = TelegramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
