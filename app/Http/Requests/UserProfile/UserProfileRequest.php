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
            "phone_prefix"     => ['required', 'starts_with:+', 'max:10'],
            "phone"            => ['required', 'regex:/^[0-9]+$/', 'max:50'],
            "country"          => $this->countryCodeRule(true),
            "firstname"        => $this->nameEngRule(true),
            "lastname"         => $this->nameEngRule(true),
            "birthday"         => $this->birthdayRule(true),
            "gender"           => $this->genderRule(true),
            "document_number"  => $this->stringRule(true),
            "document_expires" => $this->dateExpiresRule(),
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $requestData = $this->safe()->all();

        $requestData['birthday']         = $this->formatDateForInput($this->input('birthday'));
        $requestData['document_expires'] = $this->formatDateForInput($this->input('document_expires'));

        return $requestData;
    }
}
