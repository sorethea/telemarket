<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament::button icon="heroicon-o-microphone"/>
    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
