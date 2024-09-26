<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament-forms::field-wrapper>
        <x-filament::button wire:loading.inline-block icon="heroicon-o-microphone" class="w-max" wire:click.prevent="voiceRecord"/>
        <x-filament::button wire:loading.inline icon="heroicon-o-play" class="w-max" wire:click.prevent="voicePlay"/>
    </x-filament-forms::field-wrapper>
    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
