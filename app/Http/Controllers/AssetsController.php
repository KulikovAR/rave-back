<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiJsonResponse;
use App\Models\Price;
use App\Services\LocalizationService;
use Illuminate\Support\Facades\App;

class AssetsController extends Controller
{
    public function show(?string $locale = null)
    {
        if (!in_array($locale, LocalizationService::supportedLanguages())) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        $prices = Price::where('locale', $locale)->first();

        return new ApiJsonResponse(
            data: __('translations') + ['prices' => $prices]
        );
    }
}
