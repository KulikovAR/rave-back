<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;

class ChunkedFileUpload extends Component
{
    use WithFileUploads;

    // Chunks info
    public $chunkSize = 2000000; // 2M
    public $fileChunk;
    public $uploads = [];

    // Final file 
    public $fileName;
    public $fileSize;
    public $finalFile;

    public $nameSomething = 'FFUKC';

    public function updatedFileChunk()
    {
        // $path = Storage::path('/livewire-tmp/file.json');
        // $file = fopen($path, 'wb');
        // $data = $this->uploads;
        // $string = json_encode($data, JSON_PRETTY_PRINT);
        // fwrite($file, $string);
        // fwrite($file, $this->nameSomething);
        // fclose($file);
        // $oldData = Storage::get('/livewire-tmp/file.json');
        // $oldData = json_decode($oldData, true);
        // if (empty($oldData)) {
        //     $oldData = [];
        // }

        // $encoded = json_encode($this->uploads, JSON_PRETTY_PRINT);
        // Storage::put('/livewire-tmp/file.json', $encoded);



        #todo - переделать на сбор всех чанков и запись их последовательно
        $chunkFileName = $this->fileChunk->getFileName();
        $finalPath = Storage::path('/livewire-tmp/'.$this->fileName);
        $tmpPath   = Storage::path('/livewire-tmp/'.$chunkFileName);

        $file = fopen($tmpPath, 'rb');
        $final = fopen($finalPath, 'ab');

        stream_copy_to_stream($file, $final);
        unlink($tmpPath);

        $curSize = Storage::size('/livewire-tmp/' . $this->fileName);
        if ( $curSize == $this->fileSize ){
            $this->finalFile = TemporaryUploadedFile::createFromLivewire('/'.$this->fileName);
            // dd($this->finalFile);
            $path = Storage::put('public/file.jpg', file_get_contents($finalPath));
            Storage::move($finalPath, 'public/fileMEW.jpg');
            // dd($path);
        }
    }

    public function render()
    {
        return view('livewire.chunked-file-upload');
    }
}
