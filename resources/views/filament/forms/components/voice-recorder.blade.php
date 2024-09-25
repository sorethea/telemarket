<div>
    <x-filament::button  icon="heroicon-o-microphone" tooltip="Voice Recorder"></x-filament::button>


    <script>
        let mediaRecorder;

        let audioChunks = [];
        function startRecording(){
            alert("start recording");
            navigator.mediaDevices.getUserMedia({ audio: true })

                .then(stream => {

                    mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.start();

                    document.getElementById('startRecording').disabled = true;

                    document.getElementById('stopRecording').disabled = false;

                    mediaRecorder.addEventListener('dataavailable', event => {

                        audioChunks.push(event.data);

                    });

                    mediaRecorder.addEventListener('stop', () => {

                        const audioBlob = new Blob(audioChunks);

                        const audioUrl = URL.createObjectURL(audioBlob);

                        const audio = document.getElementById('audioPlayback');

                        audio.src = audioUrl;

                        uploadAudio(audioBlob);

                    });

                });

        }



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
</div>
