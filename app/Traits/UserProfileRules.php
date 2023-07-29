<?php

namespace App\Traits;

use App\Models\UserProfile;
use Illuminate\Validation\Rule;

trait UserProfileRules
{
    protected function countryCodeRule(?bool $isRequired = false): array
    {
        return
            $this->isRequired($isRequired)
            + ['string', 'regex:/^[A-Z]+$/', 'max:2'];
    }

    protected function isRequired(?bool $isRequired = false): array
    {
        return ($isRequired ? ['required'] : ['nullable']);
    }

    protected function birthdayRule(?bool $isRequired = false): array
    {
        return
            $this->isRequired($isRequired)
            + ['string', 'date_format:d.m.Y', 'before:' . today()];
    }

    protected function nameEngRule(?bool $isRequired = false): array
    {
        return
            $this->isRequired($isRequired)
            + ['string', 'regex:/^[a-zA-Z]+$/', 'max:250'];
    }

    protected function genderRule(?bool $isRequired = false): array
    {
        return
            $this->isRequired($isRequired)
            + ['string', Rule::in([UserProfile::MALE, UserProfile::FEMALE])];
    }

    protected function stringRule(?bool $isRequired = false): array
    {
        return
            $this->isRequired($isRequired)
            + ['string', 'max:9'];
    }

    protected function dateExpiresRule(?bool $isRequired = false): array
    {
        return
            $this->isRequired($isRequired)
            + ['string', 'date_format:d.m.Y', 'after_or_equal:' . today()];
    }
}

