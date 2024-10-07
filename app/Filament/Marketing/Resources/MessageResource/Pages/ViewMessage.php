<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use App\Livewire\VoiceReply;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Pages\ViewRecord;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;


    protected function getHeaderActions(): array
    {
        return[
            Action::make("voice")
                ->form([
                    ViewField::make('voice')
                        ->view("livewire.voice-reply")
                ])
                ->modal(),
        ];
    }
}
