<x-filament-panels::page>
<x-filament-panels::form>
    {{$this->form}}
    <x-filament-forms::field-wrapper>
        <x-filament-forms::field-wrapper.label>{{trans('market.message.voice_record')}}</x-filament-forms::field-wrapper.label>
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
    window.addEventListener('voiceRecord',(event)=>{
        voice_record(event['__livewire']['params'][0]['message']);
    });
    let mediaRecorder;

    let audioChunks = [];

    function voice_record(){
        navigator.mediaDevices.getUserMedia({ audio: true })

            .then(stream => {

                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.start();

                // document.getElementById('startRecording').disabled = true;
                //
                // document.getElementById('stopRecording').disabled = false;

                // mediaRecorder.addEventListener('dataavailable', event => {
                //
                //     audioChunks.push(event.data);
                //
                // });

                // mediaRecorder.addEventListener('stop', () => {
                //
                //     const audioBlob = new Blob(audioChunks);
                //
                //     const audioUrl = URL.createObjectURL(audioBlob);
                //
                //     const audio = document.getElementById('audioPlayback');
                //
                //     audio.src = audioUrl;
                //
                //     uploadAudio(audioBlob);
                //
                // });

            });
    }


    document.getElementById('startRecording').addEventListener('click', () => {



    });

    document.getElementById('stopRecording').addEventListener('click', () => {

        mediaRecorder.stop();

        document.getElementById('startRecording').disabled = false;

        document.getElementById('stopRecording').disabled = true;

    });

    document.getElementById('goToUploads').addEventListener('click', () => {

        window.location.href = '/audio/list';

    });

    function uploadAudio(audioBlob) {

        const formData = new FormData();

        formData.append('audio', audioBlob, 'voice-recording.webm');

        fetch('/api/upload-audio', {

            method: 'POST',

            body: formData,

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}',

            },

        })

            .then(response => response.json())

            .then(data => {

                console.log('Audio uploaded successfully:', data);

                window.location.href = '/audio/list';

            })

            .catch(error => console.error('Error uploading audio:', error));

    }

</script>
@endscript
