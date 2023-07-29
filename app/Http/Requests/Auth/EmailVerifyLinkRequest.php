<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class EmailVerifyLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool|\Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = $this->getUserFromUrl();

        if (!hash_equals((string)$user?->getKey(), (string)$this->route('id'))) {
            return redirect(config('front-end.email_verified_error'));
        }

        if (!hash_equals(sha1((string)$user?->getEmailForVerification()), (string)$this->route('hash'))) {
            return redirect(config('front-end.email_verified_error'));
        }

        return true;
    }

    public function getUserFromUrl(): User
    {
        return User::find((string)$this->route('id'));
    }
}
