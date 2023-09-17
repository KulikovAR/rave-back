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

            document.getElementById(inputId).style.border = '1px solid #1da1f2';
            @this.set('finalFile', '', true);
        </script>
    @endif

    <div class="filepond--root filepond--hopper" data-style-panel-layout="compact"
        data-style-button-remove-item-position="left" data-style-button-process-item-position="right"
        data-style-load-indicator-position="right" data-style-progress-indicator-position="right"
        data-style-button-remove-item-align="false" style="height: 42px;">

        <input type="file" id="videoFile" class="filepond--browser" />
        <div class="filepond--drop-label filepond-choose" style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
            <label for="videoFile" aria-hidden="true">
                <span class="filepond--label-action" tabindex="0">Выберите видео файл</span>
            </label>
        </div>
        <div class="filepond--drop-label filepond-submit" style="transform: translate3d(0px, 0px, 0px); opacity: 1; display: none;">
            <label aria-hidden="true">
                <span class="filepond--label-action" tabindex="0" onclick="uploadChunks()" style="color: #1da1f2;">Загрузить: <span id="fileNameVideo"></span></span>
            </label>
        </div>

        <div class="filepond--panel filepond--panel-root" data-scalable="true">
            <div class="filepond--panel-top filepond--panel-root"></div>
            <div class="filepond--panel-center filepond--panel-root"
                style="transform: translate3d(0px, 8px, 0px) scale3d(1, 0.26, 1);"></div>
            <div class="filepond--panel-bottom filepond--panel-root" style="transform: translate3d(0px, 34px, 0px);">
            </div>
        </div>
    </div>
    @if ($progressPercentage)
        <progress max="100" wire:model="progressPercentage" class="progressUploadVideoFile"/></progress>
        <style>
            .progressUploadVideoFile {
                width: 100%;
                height: 21px;
                margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
                overflow: hidden;
                border-radius: 8px;

            }

            .progressUploadVideoFile::-webkit-progress-bar {
                background-color: white;
            }
            .progressUploadVideoFile::-webkit-progress-value {
                background-color: #1da1f2;
            }
        </style>
    @endif

    <script>
        let chunksName = [];

        let fileInput = document.getElementById('videoFile');
        fileInput.addEventListener("change", () => {
            toogleInput(fileInput);
        });

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
            }, (event) => {});
        }

        function toogleInput(fileInput) {
            let filepondChoose = document.querySelector('.filepond-choose');
            let filepondSubmit = document.querySelector('.filepond-submit');
            if (filepondChoose === null || filepondSubmit === null) {
                return;
            }

            if (fileInput.files.length === 0) {
                filepondChoose.style.display = 'block';
                filepondSubmit.style.display = 'none';
                return;
            }

            filepondChoose.style.display = 'none';
            filepondSubmit.style.display = 'block';
            
            let fileName = fileInput.files[0].name;
            let nameFileSpan = document.querySelector('#fileNameVideo');
            nameFileSpan.innerText = fileName;
        }
    </script>
</div>
