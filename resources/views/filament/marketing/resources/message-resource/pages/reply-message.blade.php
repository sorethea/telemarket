<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament:x-filament::button.group>
        <x-filament::button icon="heroicon-o-microphone" wire:click.prevent="voiceRecord"/>
    </x-filament:x-filament::button.group>
    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
