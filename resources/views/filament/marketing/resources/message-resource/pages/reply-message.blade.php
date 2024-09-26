<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament-forms::field-wrapper class="inline-block">
        <x-filament::button  icon="heroicon-o-microphone" class="w-max inline" wire:click.prevent="voiceRecord"/>
        <x-filament::button  icon="heroicon-o-play" class="w-max inline" wire:click.prevent="voicePlay"/>
    </x-filament-forms::field-wrapper>
    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
