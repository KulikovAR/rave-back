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

        return response()->file(Storage::disk('private')->path($filePath));
    }

    public function show(Request $request)
    {

        $filePath = $request->path;

        abort_if(!Storage::disk('private')->exists($filePath), 404);

        return response()
            ->file(Storage::disk('private')
            ->path($filePath));
    }
}
