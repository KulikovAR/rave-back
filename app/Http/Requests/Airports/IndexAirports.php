<?php

namespace App\Http\Requests\Airports;

use Illuminate\Foundation\Http\FormRequest;

class IndexAirports extends FormRequest
{
    public function rules(): array
    {
        return [
            'airport' => ['required', 'string', 'max:100']
        ];
    }
}
