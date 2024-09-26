<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament::button.index class="inline">
        <x-filament::button  icon="heroicon-o-microphone" class="w-max inline" wire:click.prevent="voiceRecord"/>
        <x-filament::button  icon="heroicon-o-play" class="w-max inline" wire:click.prevent="voicePlay"/>
    </x-filament::button.index>
    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
