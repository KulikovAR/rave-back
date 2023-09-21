<?php

namespace App\Http\Resources\Banner;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'action_url' => $this->action_url,
            'img'        => $this->img ? StorageService::getUrl($this->img, config('filesystems.disks.private.temp_link_expires_image')) : null
        ];
    }
}