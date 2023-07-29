<?php

namespace App\Http\Requests\Orders;

class UpdateOrderRequest extends StoreOrderRequest
{
    public function rules(): array
    {

        return [
                'id'           => ['required', 'string', 'max:100'],
                'order_number' => ['required', 'string', 'max:100'],
            ] + parent::rules();
    }
}
