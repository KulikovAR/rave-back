<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiJsonResponse;
use App\Models\Setting;
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

        $data = __('translations');

        $data['prices'] = Setting::getPrices($locale);

        return new ApiJsonResponse(
            data: $data
        );
    }
}
