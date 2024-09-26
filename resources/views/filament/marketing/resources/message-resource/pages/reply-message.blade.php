<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament::button style="{width:200px;}" icon="heroicon-o-microphone"  wire:click.prevent="voiceRecord"/>

    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
