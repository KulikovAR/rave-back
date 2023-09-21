<?php

namespace App\Http\Resources\Proposal;

use App\Services\PrivateStorageUrlService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'file' => PrivateStorageUrlService::getUrl($this->file)
        ];
    }
}