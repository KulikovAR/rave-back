<div>
    <form wire:submit.prevent="save">
        @if ($finalFile)
            Photo Preview:
            {{ $finalFile->getFilename() }}
            <pre>
                @php
                    print_r($finalFile);
                @endphp
            </pre>
            
            {{-- <img src="{{ $finalFile->temporaryUrl() }}"> --}}
        @endif
        <input type="file" id="myFile" />
        <button type="button" id="submit" onclick="uploadChunks()">Submit</button>
    </form>

    <script>
        let chnkStarts = [];

        function uploadChunks() {
            // File Details
            const file = document.querySelector('#myFile').files[0];

            // Sent along with next call
            @this.set('fileName', file.name, true);
            @this.set('fileSize', file.size, true);

            // Upload first chunk of file
            livewireUploadChunk(file, 0);
        }

        function livewireUploadChunk(file, start) {
            console.log('livewireUploadChunk: ' + start);
            // Get chunk from start
            const chunkEnd = Math.min(start + @js($chunkSize), file.size);
            const chunk = file.slice(start, chunkEnd);

            @this.upload('fileChunk', chunk, (uName) => {}, () => {}, (event) => {
                console.log('progress: ' + event.detail.progress);
                if (event.detail.progress == 100) {
                    // We recursively call livewireUploadChunk from within itself
                    start = chunkEnd;
                    if (start < file.size) {
                        let _time = Math.floor((Math.random() * 2000) + 1);
                        console.log('sleeping ',_time,'before next chunk upload');
                        setTimeout( livewireUploadChunk, _time, file, start );

                        livewireUploadChunk(file, start);
                    }
                }
            });
        }

    </script>
</div>
