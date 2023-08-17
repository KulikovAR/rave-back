<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagSlugRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['tag_slug' => $this->route('tag_slug')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tag_slug' => 'string|exists:tags,slug'
        ];
    }
}
