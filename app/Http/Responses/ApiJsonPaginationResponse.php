<?php

namespace App\Http\Responses;

use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;

class ApiJsonPaginationResponse extends ApiJsonResponse
{
    public function toResponse($request): JsonResponse
    {
        return response()->json(
            array_merge( $this->getData(), [
                'links' => [
                    "first_page_url" => $this->data->getOptions()['path'] . '?' . $this->data->getOptions()['pageName'] . '=1',
                    "prev_page_url"  => $this->data->previousPageUrl(),
                    "next_page_url"  => $this->data->nextPageUrl(),
                    "last_page_url"  => $this->data->getOptions()['path'] . '?' . $this->data->getOptions()['pageName'] . '=' . $this->data->lastPage(),
                ],
                'meta' => [
                    "current_page"   => $this->data->currentPage(),
                    "last_page"      => $this->data->lastPage(),
                    "per_page"       => $this->data->perPage(),
                    "total"          => $this->data->total(),
                    "path"           => $this->data->getOptions()['path'],
                ],
            ]),
            $this->httpCode
        );
    }
}