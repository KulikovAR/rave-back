<?php

namespace App\Http\Requests\Proposal;

use Illuminate\Foundation\Http\FormRequest;

class ProposalRequest extends FormRequest
{
   protected function prepareForValidation()
    {
        $this->merge([
            'file' => $this->file==='null' ? null : $this->file  
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'body' => 'string|required',
            'file' => 'nullable|mimes:png,jpg,jpeg,pdf|max:20480'
        ];
    }
}
