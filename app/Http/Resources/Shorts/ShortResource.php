<?php

namespace App\Http\Resources\Shorts;

use App\Http\Resources\Slide\SlideCollection;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slide_count' => $this->slides()->count(),
            'view_count'  => $this->view_count,
            'thumbnail'   => StorageService::getUrl($this->thumbnail, config('filesystems.disks.private.temp_link_expires_image')),
            'slide'       => new SlideCollection($this->slides),
            'video_path'  => StorageService::getUrl('video/' . $this->video_path, config('filesystems.disks.private.temp_link_expires_video')),
        ];
    }

}