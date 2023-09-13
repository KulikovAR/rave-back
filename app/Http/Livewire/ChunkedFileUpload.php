<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Log;

class ChunkedFileUpload extends Component
{
    use WithFileUploads;

    // Chunks info
    public $chunkSize = 10000000; // 10M
    public $fileChunk;

    // Final file 
    public $fileName;
    public $fileSize;
    public $finalFile;

    public $nameSomething = 'FFUKC';

    public function updatedFileChunk()
    {
        $chunkFileName = $this->fileChunk->getFileName();
        $finalPath = Storage::path('/livewire-tmp/'.$this->fileName);
        $tmpPath   = Storage::path('/livewire-tmp/'.$chunkFileName);
        $file = fopen($tmpPath, 'rb');
        $buff = fread($file, $this->chunkSize);
        fclose($file);
  
        $final = fopen($finalPath, 'ab');
        fwrite($final, $buff);
        fclose($final);
        unlink($tmpPath);

        $curSize = Storage::size('/livewire-tmp/'.$this->fileName);
        if( $curSize == $this->fileSize ){
            $this->finalFile = TemporaryUploadedFile::createFromLivewire('/'.$this->fileName);
            // dd($this->finalFile);
            $path = Storage::put('public/file.jpg', file_get_contents($finalPath));
            Storage::move($finalPath, 'public/fileMEW.jpg');
        }


        // $finalPath = Storage::path('/livewire-tmp/'.$this->fileName);
        // $tmpPath   = Storage::path('/livewire-tmp/'.$this->fileChunk->getFileName());
        // $file = fopen($tmpPath, 'rb');
        // $buff = fread($file, $this->chunkSize);
        // fclose($file);

        // $final = fopen($finalPath, 'ab');
        // fwrite($final, $buff);
        // fclose($final);
        // unlink($tmpPath);
        // $curSize = Storage::size('/livewire-tmp/'.$this->fileName);

        // if( $curSize == $this->fileSize ){
        //     $this->finalFile = TemporaryUploadedFile::createFromLivewire('/'.$this->fileName);
        // }
    }

    public function render()
    {
        return view('livewire.chunked-file-upload');
    }
}
