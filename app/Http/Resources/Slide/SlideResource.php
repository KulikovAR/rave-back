<?php

namespace App\Http\Resources\Slide;

use App\Services\PrivateStorageUrlService;
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
            'file'       => PrivateStorageUrlService::getUrl($this->file),
            'created_at' => $this->created_at,
            'updated_at' => $this->update_at,
        ];
    }
}