<div>
    <h1>Voice Recorder</h1>
    <x-filament::button icon="heroicon-o-microphone" wire:click="voiceRecord"/>
</div>
@script
<script>
    window.addEventListener('voiceRecord',(event)=>{
        voice_record(event['__livewire']['params'][0]['message']);
    });
    function voice_record(event){
        alert(JSON.stringify(event));
    }
</script>
@endscript
