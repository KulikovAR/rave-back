<?php

namespace App\Http\Requests\Passengers;

use App\Traits\DateFormats;
use App\Traits\UserProfileRules;
use Illuminate\Foundation\Http\FormRequest;

class PassengerRequest extends FormRequest
{
    use DateFormats;
    use UserProfileRules;

    public function rules(): array
    {
        return [
            'firstname'        => $this->nameEngRule(true),
            'lastname'         => $this->nameEngRule(true),
            'birthday'         => $this->birthdayRule(true),
            'country'          => $this->countryCodeRule(true),
            "gender"           => $this->genderRule(true),
            "document_number"  => $this->stringRule(true),
            "document_expires" => $this->dateExpiresRule(true),
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
