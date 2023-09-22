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
            'image'         => $this->image ? Storage::disk('public')->url($this->image) : null,
            'lessons_count' => $request->user()->lessons()->whereHas('tags', function ($q) {
                $q->where('slug', $this->slug);
            })->count()
        ];
    }
}