<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament-forms::field-wrapper>
        <x-filament-forms::field-wrapper.label>@lang('market.message.voice_record')</x-filament-forms::field-wrapper.label>
        <div class="inline-flex gap-2">
            @if($showRecord)
                <x-filament::button tooltip="{{trans('market.message.record')}}" color="primary" icon="heroicon-o-microphone" class="w-max" wire:click.prevent="voiceRecord"/>
            @endif
            @if($showStop)
                    <x-filament::button tooltip="{{trans('market.message.stop')}}" color="danger" icon="heroicon-o-stop" class="w-max" wire:click.prevent="voiceStop"/>
            @endif
            @if($showPlay)
                    <x-filament::button color="success" tooltip="{{trans('market.message.play')}}" icon="heroicon-o-play" class="w-max" wire:click.prevent="voicePlay"/>
            @endif

        </div>
    </x-filament-forms::field-wrapper>


    <x-filament-panels::form.actions
        alignment="right"
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>
@script
<script>
    window.addEventListener('voiceRecord',(ev)=>{
        voice_record(ev);
    });
    function voice_record(event){
        alert(event.message);
    }
</script>
@endscript
