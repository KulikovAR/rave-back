<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class StorageService
{
    public static function getUrl(?string $path, int $duration = 30, ?string $folder = null)
    {
        if(is_null($path)) {
            return null;
        }

        if (!is_null($folder)) {
            $path = $folder . '/' . $path;
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