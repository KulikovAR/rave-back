<?php

namespace App\Http\Requests\Auth\Pass;

use App\Traits\EmailPasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    use EmailPasswordRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token'    => ['required'],
            'email'    => $this->emailInputRules(),
            'password' => $this->passwordResetRules(),
        ];
    }
}
