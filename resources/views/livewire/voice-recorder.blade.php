<div>
    <h1>Voice Recorder</h1>
    <x-filament::button icon="heroicon-o-microphone" wire:click="voiceRecord({{$this->record->customer_id}})"/>
</div>
@script
    <script>
        window.addEventListener('VoiceRecord',(event)=>{
            voiceRecord(event);
        })
        function voiceRecord(event) {
            alert(JSON.stringify(event))
        }
    </script>
@endscript
