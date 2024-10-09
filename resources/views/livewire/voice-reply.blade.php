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
<!-- load OpusMediaRecorder.umd.js. OpusMediaRecorder will be loaded. -->
<script src="https://cdn.jsdelivr.net/npm/opus-media-recorder@latest/OpusMediaRecorder.umd.js"></script>
<!-- load encoderWorker.umd.js. This should be after OpusMediaRecorder. -->
<!-- This script tag will create OpusMediaRecorder.encoderWorker. -->
<script src="https://cdn.jsdelivr.net/npm/opus-media-recorder@latest/encoderWorker.umd.js"></script>
<script>
    const workerOptions = {
        OggOpusEncoderWasmPath: 'https://cdn.jsdelivr.net/npm/opus-media-recorder@latest/OggOpusEncoder.wasm',
        WebMOpusEncoderWasmPath: 'https://cdn.jsdelivr.net/npm/opus-media-recorder@latest/WebMOpusEncoder.wasm'
    };

    // Replace MediaRecorder
    window.MediaRecorder = OpusMediaRecorder;

    let mediaRecorder=new MediaRecorder(stream, {}, workerOptions);;
    let audioChunks = [];
    window.addEventListener('voiceRecordStart',()=>{
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                //mediaRecorder = new MediaRecorder(stream);
                start(mediaRecorder);
                window.addEventListener('voiceRecordStop',()=>{
                    stop(mediaRecorder);
                    mediaRecorder.stop();
                });
            });
    });

    function start(mediaRecorder) {
        mediaRecorder.start();
        mediaRecorder.addEventListener('dataavailable', event => {
            //audioChunks = [];
            audioChunks.push(event.data);
        });

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
            formData.append('audio', audioBlob, 'voice-recording.ogg');


            fetch('/api/telegram/save-voice', {

                method: 'POST',

                body: formData,

                headers: {

                    'X-CSRF-TOKEN': '{{ csrf_token() }}',

                },

            })
        });
    }

</script>
@endscript
