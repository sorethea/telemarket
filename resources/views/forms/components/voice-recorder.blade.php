<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"

>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <x-filament::button wire:click.prevent="voiceRecord"  icon="heroicon-o-microphone" tooltip="Voice Recorder"></x-filament::button>
    </div>
</x-dynamic-component>
@script
<script>
    function viceRecord(){
        alert("Start record!");
    }
</script>
@endscript
