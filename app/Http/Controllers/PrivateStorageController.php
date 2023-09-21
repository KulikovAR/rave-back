<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PrivateStorageController extends Controller
{
    public function index($filePath, Request $request)
    {
        if (!Storage::disk('private')->exists($filePath)) { 
            abort('404'); 
        }

        return response()->file(Storage::disk('private')->path($filePath)); 
    }
}
