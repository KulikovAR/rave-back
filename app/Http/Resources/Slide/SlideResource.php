<?php

namespace App\Http\Resources\Slide;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
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
            'short_id'   => $this->short_id,
            'image'      => StorageService::getUrl($this->image, config('filesystems.disks.private.temp_link_expires_image')),
            'video_path' => StorageService::getUrl('video/' . $this->video_path, config('filesystems.disks.private.temp_link_expires_video')),
            'created_at' => $this->created_at,
            'updated_at' => $this->update_at,
        ];
    }
}