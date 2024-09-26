<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament::button size="auto" icon="heroicon-o-microphone"  wire:click.prevent="voiceRecord"/>

    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
