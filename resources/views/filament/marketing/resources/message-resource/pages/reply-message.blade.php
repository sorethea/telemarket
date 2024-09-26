<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament-forms::field-wrapper>
        <x-filament-forms::field-wrapper.label>Voice Recorder</x-filament-forms::field-wrapper.label>
        <div class="inline-flex gap-2">

            <x-filament::button  icon="heroicon-o-microphone" class="w-max" wire:click.prevent="voiceRecord"/>
            <x-filament::button  icon="heroicon-o-stop" class="w-max" wire:click.prevent="voiceStop"/>
            <x-filament::button  icon="heroicon-o-play" class="w-max" wire:click.prevent="voicePlay"/>
        </div>
    </x-filament-forms::field-wrapper>


    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
