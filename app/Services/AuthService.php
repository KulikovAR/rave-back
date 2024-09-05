<?php

namespace App\Services;
use App\Contracts\AuthServiceContract;

class LocalizationService implements AuthServiceContract
{
    public static function login(): array
    {
        return array_keys(config('localization.languages'));
    }
}
