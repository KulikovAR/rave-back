<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Notifications\AdminNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class PrivateStorageUrlService
{
    public static function getUrl(?string $path)
    {
        if(is_null($path)) {
            return null;
        }

        return URL::temporarySignedRoute(
            'storage.private',
            Carbon::now()->addMinutes(config('filesystems.disks.private.temp_link_expires')),
            [
                'filePath' => $path
            ]
        );
    }
}