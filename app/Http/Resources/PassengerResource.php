<?php

namespace App\Http\Resources;

use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerResource extends JsonResource
{
    use DateFormats;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tripToArrivalDate   = json_decode($request->trip_to, true)['arrival_date'] ?? null;
        $tripBackArrivalDate = json_decode($request->trip_back, true)['arrival_date'] ?? null;

        return [
            'id'               => $this->id,
            'type'             => $this->passengerType($this->birthday, $tripBackArrivalDate ?? $tripToArrivalDate),
            'firstname'        => $this->firstname,
            'lastname'         => $this->lastname,
            'birthday'         => $this->formatDateForOutput($this->birthday),
            'gender'           => $this->gender,
            'country'          => $this->country,
            'document_number'  => $this->document_number,
            'document_expires' => $this->formatDateForOutput($this->document_expires),
        ];
    }


}
