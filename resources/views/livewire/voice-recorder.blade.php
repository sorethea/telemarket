<div>
    <h1>Voice Recorder</h1>
    <x-filament::button icon="heroicon-o-microphone" wire:click="voiceRecord"/>
</div>
@script
    <script>
        function voiceRecord() {
            alert("Voice Record!")
        }
    </script>
@endscript
