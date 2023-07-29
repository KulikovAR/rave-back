<?php

namespace App\Http\Requests\Promocodes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromocodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_partner === true;
    }

    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'promo_code' => ['required', 'string', 'max:255', Rule::unique('promocodes', 'promo_code')->ignore($this->id)],
            'commission' => ['required', 'numeric', 'max:10', 'min:0'],
            'discount'   => ['required', 'numeric', 'max:10', 'min:0'],
        ];
    }
}
