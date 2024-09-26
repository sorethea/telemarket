<div>
    <h1>Voice Recorder</h1>
    <x-filament::button icon="heroicon-o-microphone" wire:click="voiceRecord(12)"/>
</div>
@script
    <script>
            window.addEventListener('VoiceRecord',(event)=>{
            voiceRecord(event['__livewire']['params'][0]['chatId']);
        });
            function voiceRecord(event){
            alert(JSON.stringify(event));
        }
    </script>
@endscript
