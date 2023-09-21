<?php

namespace App\Http\Resources;

use App\Services\StorageService;
use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserProfileResource extends JsonResource
{
    use DateFormats;

    public function toArray(Request $request): array
    {
        return [
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'avatar'    => StorageService::getUrl($this->avatar, config('filesystems.disks.private.temp_link_expires_image'))
        ];
    }
}