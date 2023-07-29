<?php

namespace App\Http\Requests\Bank;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'org_inn'      => ['required', 'numeric', 'max_digits:255'],
            'org_kpp'      => ['required', 'numeric', 'max_digits:255'],
            'org_ogrn'     => ['required', 'numeric', 'max_digits:255'],
            'org_name'     => ['required', 'string', 'max:255'],
            'org_address'  => ['required', 'string', 'max:255'],
            'org_location' => ['nullable', 'string', 'max:255'],

            'contact_job'   => ['required', 'string', 'max:255'],
            'contact_fio'   => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_tel'   => ['required', 'string', 'max:255'],

            'bank_bik'          => ['required', 'numeric', 'max_digits:255'],
            'bank_user_account' => ['required', 'numeric', 'max_digits:255'],
            'bank_account'      => ['required', 'numeric', 'max_digits:255'],
            'bank_name'         => ['required', 'string', 'max:255'],
        ];
    }
}
