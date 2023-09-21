<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class StorageService
{
    public static function getUrl(?string $path, int $duration = 30)
    {
        if(is_null($path)) {
            return null;
        }

        return URL::temporarySignedRoute(
            'storage.private',
            Carbon::now()->addMinutes($duration),
            [
                'filePath' => $path
            ]
        );
    }
}