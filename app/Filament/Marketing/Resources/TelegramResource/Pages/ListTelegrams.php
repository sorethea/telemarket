<?php

namespace App\Filament\Marketing\Resources\TelegramResource\Pages;

use App\Filament\Marketing\Resources\TelegramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTelegrams extends ListRecords
{
    protected static string $resource = TelegramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
