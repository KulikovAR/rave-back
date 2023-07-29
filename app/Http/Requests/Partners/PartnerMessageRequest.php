<?php

namespace App\Http\Requests\Partners;

use App\Models\TakeOut;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'partner_url_location' => ['required', 'string', 'max:255'],

            'take_out_type' => ['required', Rule::in([TakeOut::TAKEOUT_BANK, TakeOut::TAKEOUT_CARD])],

            'card_number'    => ['required_if:take_out_type,' . TakeOut::TAKEOUT_CARD, 'numeric', 'max_digits:255'],
            'card_bank_name' => ['required_if:take_out_type,' . TakeOut::TAKEOUT_CARD, 'string', 'max:255'],

            'org_inn'      => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'numeric', 'max_digits:255'],
            'org_kpp'      => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'numeric', 'max_digits:255'],
            'org_ogrn'     => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'numeric', 'max_digits:255'],
            'org_name'     => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'string', 'max:255'],
            'org_address'  => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'string', 'max:255'],
            'org_location' => ['nullable', 'string', 'max:255'],

            'contact_job'   => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'string', 'max:255'],
            'contact_fio'   => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'string', 'max:255'],
            'contact_email' => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'email', 'max:255'],
            'contact_tel'   => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'string', 'max:255'],

            'bank_bik'          => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'numeric', 'max_digits:255'],
            'bank_user_account' => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'numeric', 'max_digits:255'],
            'bank_account'      => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'numeric', 'max_digits:255'],
            'bank_name'         => ['required_if:take_out_type,' . TakeOut::TAKEOUT_BANK, 'string', 'max:255'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $requestData = $this->safe()->all();


        if ($this->input('take_out_type') === TakeOut::TAKEOUT_CARD) {
            $requestDataFormatted = [];

            $requestDataFormatted['card_number']    = $requestData['card_number'];
            $requestDataFormatted['card_bank_name'] = $requestData['card_bank_name'];

            return $requestDataFormatted;
        }


        unset($requestData['take_out_type']);
        unset($requestData['card_number']);
        unset($requestData['card_bank_name']);
        unset($requestData['partner_url_location']);

        return $requestData;
    }
}
