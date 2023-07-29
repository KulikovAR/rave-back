<?php

namespace App\Http\Requests\CreditCard;

use Illuminate\Foundation\Http\FormRequest;

class CreditCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'card_number'    => ['required', 'numeric', 'max_digits:255'],
            'card_bank_name' => ['required', 'string', 'max:255'],
        ];
    }
}
