<?php

namespace App\Http\Resources\Announce;

use App\Services\PrivateStorageUrlService;
use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AnnounceResource extends JsonResource
{
    use DateFormats;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'video_path'   => PrivateStorageUrlService::getUrl('video/'.$this->video_path),
            // 'video_path'   => config('app.url') . '/storage/video/' . $this->video_path,
            'preview_path' => PrivateStorageUrlService::getUrl($this->preview_path),
            'release_at'   => $this->formatDateTimeForOutput($this->release_at),
            'main'         => (bool) $this->main
        ];
    }
}