<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class VoiceRecorder extends Component
{

    public function render(): View
    {
        return view('livewire.voice-recorder');
    }

    public function record():void{
        $this->dispatch('voice-record');
    }
}
