<?php

namespace App\Http\Resources;

use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    use DateFormats;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'phone_prefix' => $this->phone_prefix,
            'phone'        => $this->phone,
            'email'        => $this->email,
            'comment'      => $this->comment,

            'price'      => $this->price,
            'promo_code' => $this->promo_code,
            'commission' => $this->commission,
            'discount'   => $this->discount,

            'hotel_city'      => $this->hotel_city,
            'hotel_check_in'  => $this->formatDateForOutput($this->hotel_check_in),
            'hotel_check_out' => $this->formatDateForOutput($this->hotel_check_out),

            'trip_to'   => $this->trip_to,
            'trip_back' => $this->trip_back,

            'order_type'          => $this->order_type,
            'order_start_booking' => $this->formatDateForOutput($this->order_start_booking),
            'order_status'        => $this->order_status,
            'order_number'        => $this->order_number,

            'created_at' => $this->formatDateForOutput($this->created_at),

            'passengers' => new PassengerCollection($this->orderPassenger)
        ];
    }
}
