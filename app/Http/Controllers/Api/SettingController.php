<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index(): ApiJsonResponse
    {
        // Получаем все настройки
        $settings = $this->settingService->getAllSettings();

        // Если настройки не найдены
        if ($settings->isEmpty()) {
            return new ApiJsonResponse(404, false, 'No settings found');
        }

        return new ApiJsonResponse(data: $settings);
    }

    public function show($key): ApiJsonResponse
    {
        // Получаем настройку по ключу
        $setting = $this->settingService->getSettingByKey($key);

        if (! $setting) {
            return new ApiJsonResponse(404, false, 'Setting not found');
        }

        return new ApiJsonResponse(data: $setting);
    }

    public function store(Request $request): ApiJsonResponse
    {
        // Валидируем данные
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|unique:settings,key',
            'value' => 'required|string',
        ]);

        // Создаем настройку
        $setting = $this->settingService->createSetting($validated);

        return new ApiJsonResponse(201, data: $setting);
    }

    public function update(Request $request, $key): ApiJsonResponse
    {
        // Валидируем данные
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'value' => 'sometimes|string',
        ]);

        // Обновляем настройку
        $setting = $this->settingService->updateSetting($key, $validated);

        if (! $setting) {
            return new ApiJsonResponse(404, false, 'Setting not found');
        }

        return new ApiJsonResponse(data: $setting);
    }

    public function destroy($key): ApiJsonResponse
    {
        // Удаляем настройку
        $setting = $this->settingService->deleteSetting($key);

        if (! $setting) {
            return new ApiJsonResponse(404, false, 'Setting not found');
        }

        return new ApiJsonResponse(message: 'Setting deleted successfully');
    }
}
