<?php

namespace App\Http\Resources\Shorts;

use App\Http\Resources\Slide\SlideCollection;
use App\Services\PrivateStorageUrlService;
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
            'title'       => $this->title,
            'slide_count' => $this->slides()->count(),
            'view_count'  => $this->view_count,
            'thumbnail'   => PrivateStorageUrlService::getUrl($this->thumbnail),
            'slide'       => new SlideCollection($this->slides),
            'video_path'  => PrivateStorageUrlService::getUrl('video/' . $this->video_path),
            // 'video_path'  => config('app.url') . '/storage/video/' . $this->video_path,
        ];
    }

}