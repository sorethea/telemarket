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

    public int $messageId;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->messageId = $record;
    }

    public function voiceRecord(): void
    {
        $this->dispatch('voiceRecordStart',['message'=>"This is a dispatch."]);
        $this->showStop = true;
    }

    public function voiceStop(): void
    {
        $this->dispatch('voiceRecordStop',['message'=>"This is a dispatch."]);
        $this->showStop = false;
    }

    protected function getHeaderActions(): array
    {
        return[
            Action::make("voice-reply")
                ->form([
                    ViewField::make('voice-reply')
                        ->view("livewire.voice-reply")
                ])
                ->modalSubmitAction(false)
                ->modalSubmitActionLabel('Reply')
                ->modal(),
        ];
    }
}
