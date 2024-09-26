<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    public function voiceRecord(): void
    {
        $this->dispatch('VoiceRecorder',['chatId'=>]);
        Notification::make('voice-record')
            ->title("Vice Record")
            ->body("Record voice and send through telegram.")
            ->send();
    }
}
