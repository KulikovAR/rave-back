<?php

namespace App\Http\Responses;

use App\Enums\StatusEnum;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use stdClass;

class ApiJsonResponse implements Responsable
{
    public function __construct(
        public readonly int          $httpCode = 200,
        public readonly StatusEnum   $status = StatusEnum::OK,
        public readonly string       $message = "",
        public readonly object|array $data = new stdClass(),
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            [
                "status"  => $this->status->value,
                "message" => $this->message,
                "data"    => $this->data
            ],
            $this->httpCode
        );
    }
}