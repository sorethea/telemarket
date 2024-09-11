<?php

namespace App\Filament\Marketing\Resources\CommandResource\Pages;

use App\Filament\Marketing\Resources\CommandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommand extends EditRecord
{
    protected static string $resource = CommandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
