<?php

namespace App\Http\Requests\Partners;

use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\TakeOut;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class TakeOutRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'takeoutable_id'   => ['required', 'uuid'],
            'takeoutable_type' => ['required', Rule::in([TakeOut::TAKEOUT_BANK, TakeOut::TAKEOUT_CARD])],
            'amount'           => ['required', 'numeric', 'max_digits:255'],

        ];
    }

    public function validated($key = null, $default = null)
    {
        $requestData = $this->safe()->all();

        $requestData['takeoutable_type'] = $this->input('takeoutable_type') === TakeOut::TAKEOUT_CARD
            ? CreditCard::class
            : Bank::class;

        return $requestData;
    }
}
