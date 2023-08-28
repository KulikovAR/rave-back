<?php

namespace App\Http\Requests\Auth;

use App\Traits\EmailPasswordRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RegistrationEmailRequest extends FormRequest
{
    use EmailPasswordRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "firstname"   => "string|required|max:255",
            "lastname"    => "string|required|max:255",
            'email'       => $this->emailCreationRules(),
            'password'    => $this->passwordCreationRules(),
            'password_confirmation' => 'required|min:8'
        ];
    }
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->input('password') !== $this->input('password_confirmation'))
                    $validator->errors()->add(
                        'password',
                        __('password.confirmed', ['attribute' => 'password'])
                    );
            }
        ];
    }
}