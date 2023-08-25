<?php

namespace App\Http\Requests\Auth;

use App\Traits\EmailPasswordRules;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginEmailRequest extends FormRequest
{
    use EmailPasswordRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'    => $this->emailInputRules(),
            'password' => ['required', 'string', 'max:50'],
            'device_name' => "required|string|max:255"
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(callable $passwordCheck): void
    {
        $this->ensureIsNotRateLimited();

        $email      = $this->input('email');
        $password   = $this->input('password');
        $rememberMe = $this->boolean('remember');

        $uniqueId = $this->input('email');

        if (!$passwordCheck($email, $password, $rememberMe)) {

            RateLimiter::hit(
                $this->throttleKey($uniqueId)
            );

            throw ValidationException::withMessages([
                                                        'password' => __('auth.failed'),
                                                    ]);
        }

        RateLimiter::clear($this->throttleKey($uniqueId));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function ensureIsNotRateLimited(): void
    {
        $uniqueId = $this->input('email');

        if (!RateLimiter::tooManyAttempts($this->throttleKey($uniqueId), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey($uniqueId));

        throw ValidationException::withMessages([
                                                    'password' => trans('auth.throttle', [
                                                        'seconds' => $seconds,
                                                        'minutes' => ceil($seconds / 60),
                                                    ]),
                                                ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    private function throttleKey(string $uniqueId): string
    {
        return Str::transliterate(Str::lower($uniqueId) . '|' . $this->ip());
    }
}
