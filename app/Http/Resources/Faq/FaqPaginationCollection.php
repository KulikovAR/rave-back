<?php

namespace App\Http\Resources\Faq;

use App\Traits\PaginationData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FaqPaginationCollection extends ResourceCollection
{
    use PaginationData;
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['data' => $this->collection] + $this->getPaginationData();
    }
}
