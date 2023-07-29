<?php

namespace App\Http\Responses;

use App\Enums\StatusEnum;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class ApiCollectionResponse implements Responsable
{
    public function __construct(
        public readonly int                   $httpCode,
        public readonly StatusEnum            $status,
        public readonly string                $message = "",
        public readonly JsonResource|stdClass $resource = new stdClass(),
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            [
                "status"  => $this->status->value,
                "message" => $this->message,
                "data"    => $this->resource
            ]
        );
    }
}