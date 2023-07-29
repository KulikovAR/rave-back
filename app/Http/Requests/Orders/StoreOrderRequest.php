<?php

namespace App\Http\Requests\Orders;

use App\Models\Order;
use App\Traits\DateFormats;
use App\Traits\UserProfileRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    use DateFormats;
    use UserProfileRules;

    public function rules(): array
    {

        return [
            'email'        => ['required', 'string', 'email', 'max:100'],
            "phone_prefix" => ['nullable', 'starts_with:+', 'max:10'],
            "phone"        => ['nullable', 'string', 'regex:/^[0-9]+$/', 'max:50'],
            'comments'     => ['nullable', 'string', 'max:250'],

            'order_type'          => ['required', Rule::in([Order::TYPE_NORMAL, Order::TYPE_VIP])],
            'order_start_booking' => $this->dateExpiresRule(true),

            'passengers'                    => ['required', 'array', 'min:1'],
            'passengers.*.firstname'        => $this->nameEngRule(true),
            'passengers.*.lastname'         => $this->nameEngRule(true),
            'passengers.*.birthday'         => $this->birthdayRule(true),
            'passengers.*.country'          => $this->countryCodeRule(true),
            "passengers.*.gender"           => $this->genderRule(true),
            "passengers.*.document_number"  => $this->stringRule(true),
            "passengers.*.document_expires" => $this->dateExpiresRule(true),


            'trip_to'   => ['required', 'json', 'max:20000'],
            'trip_back' => ['nullable', 'json', 'max:20000'],

            'hotel_city'      => $this->stringRule(),
            'hotel_check_in'  => $this->dateExpiresRule(),
            'hotel_check_out' => $this->dateExpiresRule(),

            //'register_user' => ['nullable', 'bool'],
            //'user_id'       => ['nullable', 'string', Rule::exists('users', 'id')]
            'promo_code'      => ['nullable', 'string', 'max:50'],
        ];
    }

    public function validated($key = null, $default = null): array
    {

        $requestData = $this->safe()->all();

        $tripToArrivalDate   = json_decode($this->input('trip_to'), true)['arrival_date'] ?? null;
        $tripBackArrivalDate = json_decode($this->input('trip_back'), true)['arrival_date'] ?? null;

        $this->order_start_booking = $this->formatDateForInput($this->input('order_start_booking'));
        $this->hotel_check_in      = $this->formatDateForInput($this->input('hotel_check_in'));
        $this->hotel_check_out     = $this->formatDateForInput($this->input('hotel_check_out'));

        foreach ($requestData['passengers'] as $i => $passenger) {
            $requestData['passengers'][$i]['birthday']         = $this->formatDateForInput($passenger['birthday']);
            $requestData['passengers'][$i]['document_expires'] = $this->formatDateForInput($passenger['document_expires'] ?? null);
            $requestData['passengers'][$i]['type']             = $this->passengerType($passenger['birthday'], $tripBackArrivalDate ?? $tripToArrivalDate);
        }

        return $requestData;
    }
}
