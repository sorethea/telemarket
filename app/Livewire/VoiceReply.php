<?php

namespace App\Livewire;

use Livewire\Component;

class VoiceReply extends Component
{
    public bool $showRecord = true;
    public bool $showStop = false;

    public function render()
    {
        return view('livewire.voice-reply');
    }
}
