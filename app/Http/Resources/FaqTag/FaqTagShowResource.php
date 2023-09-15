<?php

namespace App\Http\Resources\FaqTag;

use App\Http\Resources\Faq\FaqPaginationCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqTagShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'faqs' => new FaqPaginationCollection(
                $this->faqs()->paginate(config('pagination.per_page'), ['*'], 'faq_page')
            )
        ];
    }
}