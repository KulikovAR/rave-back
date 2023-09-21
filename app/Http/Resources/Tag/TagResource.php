<?php

namespace App\Http\Resources\Tag;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'          => $this->name,
            'slug'          => $this->slug,
            'image'         => StorageService::getUrl($this->image, config('filesystems.disks.private.temp_link_expires_image')),
            'lessons_count' => $request->user()->lessons()->whereHas('tags', function ($q) {
                $q->where('slug', $this->slug);
            })->count()
        ];
    }
}