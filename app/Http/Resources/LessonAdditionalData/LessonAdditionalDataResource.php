<?php

namespace App\Http\Resources\LessonAdditionalData;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonAdditionalDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'file'  => StorageService::getUrl($this->file, config('filesystems.disks.private.temp_link_expires_video')),
        ];
    }
}