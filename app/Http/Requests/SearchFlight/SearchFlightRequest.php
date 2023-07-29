<?php

namespace App\Http\Requests\SearchFlight;

use App\Traits\DateFormats;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class SearchFlightRequest extends FormRequest
{
    use DateFormats;

    public function rules(): array
    {
        return [
            'airport_from'  => ['required', 'string', 'regex:/^[A-Z]+$/', 'max:255'],
            'airport_to'    => ['required', 'string', 'regex:/^[A-Z]+$/', 'max:255'],
            "date_start"    => ['required', 'date_format:d.m.Y', 'after_or_equal:' . today()],
            "date_back"     => ['nullable', 'date_format:d.m.Y', 'after_or_equal:' . today()],
            "time_begin"    => ['nullable', 'numeric', 'min:0'],
            "time_end"      => ['nullable', 'numeric', 'max:1439'],
            'adults'        => ['required', 'numeric'],
            'children'      => ['required', 'numeric'],
            'babies'        => ['required', 'numeric'],
            'service_class' => ['required', Rule::in(['ECONOMY', 'BUSINESS', 'FIRST', 'PREMIUM', 'PREMIUM_BUSINESS', 'PREMIUM_FIRST'])],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $timeNow = Carbon::now()->format('H:i:s');

        $requestData = $this->safe()->all();

        $dateStart = $this->formatDateForInput($this->input('date_start'));
        $dateEnd   = $this->formatDateForInput($this->input('date_back'));


        $requestData['date_start'] = Carbon::parse($dateStart . ' ' . $timeNow)->toISOString();

        if (!empty($requestData['date_back'])) {
            $requestData['date_back'] = Carbon::parse($dateEnd)->toISOString();
        } else {
            $requestData['date_back'] = null;
        }


        return $requestData;
    }

    protected function prepareForValidation(): void
    {
        if ($this->date_back === 'null')
            $this->merge(['date_back' => null]);
    }
}
