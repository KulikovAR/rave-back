<?php

namespace App\Http\Resources\Lesson;

use App\Traits\PaginationData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LessonPaginationCollection extends ResourceCollection
{
    use PaginationData;

    public $collects = LessonResource::class;
    
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