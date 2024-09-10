<?php

namespace App\Filament\Marketing\Resources\TelegramResource\Pages;

use App\Filament\Marketing\Resources\TelegramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTelegram extends EditRecord
{
    protected static string $resource = TelegramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
