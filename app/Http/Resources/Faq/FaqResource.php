<?php

namespace App\Http\Resources\Faq;

use App\Http\Resources\FaqTag\FaqTagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question' => $this->question,
            'answer'   => $this->answer,
            'fag_tag'  => new FaqTagResource($this->faqTag)
        ];
    }
}