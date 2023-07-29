<?php

namespace App\Interfaces;

interface FetchFlightInterface
{
    public function fetch(array $request): string;
}