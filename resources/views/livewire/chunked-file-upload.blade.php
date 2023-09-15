<div>
    @if ($finalFile)
    <script>
        console.log('finalFile: ' + '{{ $finalFile->getFilename() }}');
        let inputId = '{{ $inputId }}';
        if (inputId == '') {
            inputId = 'data.video';
        }

        document.getElementById(inputId).dispatchEvent(new Event("input"));
        document.getElementById(inputId).value = '{{ $finalFile->getFilename() }}';
        document.getElementById(inputId).setAttribute("value", '{{ $finalFile->getFilename() }}');
    </script>
    finalFile: {{ $finalFile->getFilename() }}
    @endif

    <input type="file" id="videoFile" />
    <button type="button" id="submit" onclick="uploadChunks()">Submit</button>

    @if( $progressPercentage  )
        <progress max="100" wire:model="progressPercentage" /></progress>
    @endif
    <script>
        let chunksName = [];

        function uploadChunks() {
            const file = document.querySelector('#videoFile').files[0];
            if (!file) {
                return;
            }

            @this.set('fileName', file.name, true);
            @this.set('fileSize', file.size, true);
            @this.set('progressPercentage', 0);

            $chunks = getAllChunks(file);
            if ($chunks.length === 0) {
                return;
            }

            uploadFile(file, $chunks);
        }

        function getAllChunks(file) {
            const chunks = [];
            let start = 0;

            while (start < file.size) {
                const chunkEnd = Math.min(start + @js($chunkSize), file.size);
                chunks.push([start, chunkEnd]);
                start = chunkEnd;
            }

            return chunks;
        }

        function uploadFile(file, chunks) {
            let lengthChunks = chunks.length;
            let counter = 1;

            chunks.forEach((item) => {
                let start = item[0];
                let end = item[1];
                let chunk = file.slice(start, end);

                tryToUploadChunk(chunk, counter, lengthChunks);
                counter++;
            });

            console.log('chunks: ' + chunksName);
        }

        function tryToUploadChunk(chunk, counter, lengthChunks) {
            @this.upload('fileChunk', chunk, (uploadedFilename) => {
                console.log('uploadedFilename: ' + uploadedFilename + ' counter: ' + counter + '/' + lengthChunks);
                @this.set('progressPercentage', Math.round((counter / lengthChunks) * 100));
            }, () => {
                console.log('error');
                let _time = Math.floor((Math.random() * 20000) + 1);
                setTimeout(tryToUploadChunk, _time, chunk, counter);
            }, (event) => {
            });
        }
    </script>
</div>
