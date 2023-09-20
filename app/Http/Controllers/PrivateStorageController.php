<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrivateStorageController extends Controller
{
    public function index($filePath)
    {
        if (!Storage::disk('private')->exists($filePath)) { 
            abort('404'); 
        }

        return response()->file(storage_path('app' . DIRECTORY_SEPARATOR . ($filePath))); // the response()->file() will add the necessary headers in our place (no headers are needed to be provided for images (it's done automatically) expected hearder is of form => ['Content-Type' => 'image/png'];
    }
}
