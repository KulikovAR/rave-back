<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;

class ChunkedFileUpload extends Component
{
    use WithFileUploads;

    public $chunkSize = 2000000; // 2M
    public $fileChunk;
    public $uploads = [];

    public $fileName;
    public $fileSize;
    public $finalFile;

    public function updatedFileChunk()
    {
        $chunkFileName = $this->fileChunk->getFileName();
        $finalPath = Storage::path('/livewire-tmp/' . $this->fileName);
        $tmpPath   = Storage::path('/livewire-tmp/' . $chunkFileName);

        $tempfile = fopen($tmpPath, 'rb');
        $final = fopen($finalPath, 'ab');

        stream_copy_to_stream($tempfile, $final);
        fclose($tempfile);
        fclose($final);
        unlink($tmpPath);

        $curSize = Storage::size('/livewire-tmp/' . $this->fileName);
        if ($curSize == $this->fileSize) {
            $this->finalFile = TemporaryUploadedFile::createFromLivewire('/' . $this->fileName);
            $path = '/livewire-tmp/' . $this->fileName;
            $newPath = '/public/video/' . $this->fileName;
            Storage::move($path, $newPath);
        }
    }

    public function render()
    {
        return view('livewire.chunked-file-upload');
    }
}
