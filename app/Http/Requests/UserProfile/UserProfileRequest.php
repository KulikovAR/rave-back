<?php

namespace App\Http\Requests\UserProfile;

use App\Traits\DateFormats;
use App\Traits\UserProfileRules;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    use DateFormats;
    use UserProfileRules;

    public function rules(): array
    {
        return [
            "firstname" => "string|required",
            "lastname"  => "string|required",
            'image'     => 'image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}