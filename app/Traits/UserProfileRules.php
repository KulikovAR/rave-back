<?php

namespace App\Traits;

use App\Models\UserProfile;
use Illuminate\Validation\Rule;

trait UserProfileRules
{
    protected function isRequired(?bool $isRequired = false): array
    {
        return ($isRequired ? ['required'] : ['nullable']);
    }
}

