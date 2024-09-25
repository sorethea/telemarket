<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Livewire;

class VoiceRecorder extends Field
{
    protected string $view = 'forms.components.voice-recorder';

    public function voiceRecord(): void
    {
        dispatch('vice-record');
    }
}
