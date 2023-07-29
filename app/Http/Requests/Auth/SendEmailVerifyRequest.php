<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Traits\EmailPasswordRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SendEmailVerifyRequest extends FormRequest
{
    use EmailPasswordRules;

    public function rules(): array
    {
        return [
            'email' => $this->emailInputRules()
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->isEmailUnique($this->user(), $this->input('email'))) {
                    $validator->errors()->add(
                        'email',
                        __('validation.unique', ['attribute' => 'email'])
                    );
                }
            }
        ];
    }

    private function isEmailUnique(User $user, string $email): bool
    {
        $alreadyExistingUser = null;

        if ($user->email !== $email) {
            $alreadyExistingUser = User::whereEmail($email)->first();
        }

        return $alreadyExistingUser !== null;
    }
}
