<div>
    <x-filament-panels::form>
        <x-filament-forms::field-wrapper>
            <div class="inline-flex gap-2">
                @if($this->showRecord)
                    <x-filament::button id="startRecording" tooltip="{{trans('market.message.record')}}"  color="primary" icon="heroicon-o-microphone" class="w-max" wire:click.prevent="voiceRecord"/>
                @endif
                @if($this->showStop)
                    <x-filament::button id="stopRecording" tooltip="{{trans('market.message.stop')}}" color="danger" icon="heroicon-o-stop" class="w-max" wire:click.prevent="voiceStop" />
                @endif
                <audio id="audioPlayback" controls></audio>
            </div>
        </x-filament-forms::field-wrapper>
        <x-filament-panels::form.actions
            alignment="right"
            :actions="$this->getFormActions()"
        />

    </x-filament-panels::form>
</div>
@script
<script>

    let mediaRecorder;
    let audioChunks = [];
    window.addEventListener('voiceRecordStart',()=>{
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                start(mediaRecorder);
                window.addEventListener('voiceRecordStop',()=>{
                    stop(mediaRecorder);
                });
            });
    });

    function start(mediaRecorder) {
        mediaRecorder.start();
        // mediaRecorder.addEventListener('dataavailable', event => {
        //     audioChunks.push(event.data);
        // });

    }

    function stop(mediaRecorder){
        mediaRecorder.addEventListener('stop', () => {

            const audioBlob = new Blob(audioChunks);

            const audioUrl = URL.createObjectURL(audioBlob);

            const audio = document.getElementById('audioPlayback');

            audio.src = audioUrl;


            const formData = new FormData();
            // formData.append('bot','ichiban');
            formData.append('customer_id',{{$this->customerId}});
            formData.append('audio', audioBlob, 'voice-recording.webm');


            fetch('/api/telegram/save-voice', {

                method: 'POST',

                body: formData,

                headers: {

                    'X-CSRF-TOKEN': '{{ csrf_token() }}',

                },

            })
            mediaRecorder.stop();
        });
    }

</script>
@endscript
