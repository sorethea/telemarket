<div>
    <h1>Voice Recorder</h1>
    <x-filament::button icon="heroicon-o-microphone" wire:click="js:alert('voice record')"/>
</div>
@script
<script>
    function voiceRecord(){
        alert("Voice Record!")
    }
</script>
@endscript
