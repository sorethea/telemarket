<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament-forms::field-wrapper>
        <x-filament-forms::field-wrapper.label>{{trans('market.message.voice_record')}}</x-filament-forms::field-wrapper.label>
        <div class="inline-flex gap-2">
{{--            @if($showRecord)--}}
{{--                <x-filament::button tooltip="{{trans('market.message.record')}}" id="startRecording" color="primary" icon="heroicon-o-microphone" class="w-max" wire:click.prevent="voiceRecord"/>--}}
{{--            @endif--}}
{{--            @if($showStop)--}}
{{--                    <audio controls>--}}
{{--                        <source src="" >--}}
{{--                    </audio>--}}
{{--                    <x-filament::button id="stopRecording" tooltip="{{trans('market.message.stop')}}" color="danger" icon="heroicon-o-stop" class="w-max" wire:click.prevent="voiceStop"/>--}}
{{--            @endif--}}
{{--            @if($showPlay)--}}

{{--                    <x-filament::button color="success" tooltip="{{trans('market.message.play')}}" icon="heroicon-o-play" class="w-max" wire:click.prevent="voicePlay"/>--}}
{{--            @endif--}}
            <h1>Record and Upload Audio</h1>

            <button id="startRecording">Start Recording</button>

            <button id="stopRecording" disabled>Stop Recording</button>

            <button id="goToUploads">View Uploaded Files</button>

            <audio id="audioPlayback" controls></audio>

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
    let mediaRecorder;

    let audioChunks = [];
    window.addEventListener('voiceRecord',()=>{

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {

                    mediaRecorder = new MediaRecorder(stream);

                    start(mediaRecorder)
                    mediaRecorder.addEventListener('stop', () => {

                        const audioBlob = new Blob(audioChunks);

                        const audioUrl = URL.createObjectURL(audioBlob);

                        const audio = document.getElementById('audioPlayback');

                        audio.src = audioUrl;


                    });

                });
    });


    function start(mediaRecorder) {
        mediaRecorder.start();


        mediaRecorder.addEventListener('dataavailable', event => {

            audioChunks.push(event.data);

        });

    }

</script>
@endscript
