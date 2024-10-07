<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use App\Livewire\VoiceReply;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;

    public bool $showRecord = true;
    public bool $showStop = false;

    public function voiceRecord(): void
    {
        $this->dispatch('voiceRecordStart',['message'=>"This is a dispatch."]);
        Notification::make('voice-record')
            ->title("Vice Record")
            ->body("Record voice and send through telegram.")
            ->send();
        $this->showStop = true;
    }

    protected function getHeaderActions(): array
    {
        return[
            Action::make("voice-reply")
                ->form([
                    ViewField::make('voice-reply')
                        ->view("livewire.voice-reply")
                ])
                ->modal(),
        ];
    }
}
