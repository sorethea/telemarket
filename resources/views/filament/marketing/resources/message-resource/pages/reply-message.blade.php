<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament::button maxlength="35">@lang("market.message.reply")</x-filament::button>
    <x-filament-panels::form.actions
        :actions="$this->getActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
