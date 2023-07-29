<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthProviderRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'provider' => [
                'required',
                Rule::in(config('auth-providers.all'))
            ]
        ];
    }

    /**
     * Get the validated data from the request.
     *
     */
    public function validated($key = null, $default = null): string
    {
        $data = $this->validator->validated();

        return strtolower($data['provider'] ?? "");
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['provider' => $this->route('provider')]);
    }
}
