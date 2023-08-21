<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;
use stdClass;

trait PaginationData
{
    protected function getPaginationData(): array
    {
        return [
            'links' => [
                "first" => $this->getOptions()['path'] . '?' . $this->getOptions()['pageName'] . '=1',
                "prev"  => $this->previousPageUrl(),
                "next"  => $this->nextPageUrl(),
                "last"  => $this->getOptions()['path'] . '?' . $this->getOptions()['pageName'] . '=' . $this->lastPage(),
            ],
            'meta'  => [
                "current_page" => $this->currentPage(),
                "last_page"    => $this->lastPage(),
                "per_page"     => $this->perPage(),
                "total"        => $this->total(),
                "path"         => $this->getOptions()['path'],
            ],
        ];
    }
}