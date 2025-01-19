<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getAllSettings();
        return response()->json($settings, 200);
    }

    public function show($key)
    {
        $setting = $this->settingService->getSettingByKey($key);

        if (!$setting) {
            return response()->json(['error' => 'Setting not found'], 404);
        }

        return response()->json($setting, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|unique:settings,key',
            'value' => 'required|string',
        ]);

        $setting = $this->settingService->createSetting($validated);
        return response()->json($setting, 201);
    }

    public function update(Request $request, $key)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'value' => 'sometimes|string',
        ]);

        $setting = $this->settingService->updateSetting($key, $validated);

        if (!$setting) {
            return response()->json(['error' => 'Setting not found'], 404);
        }

        return response()->json($setting, 200);
    }

    public function destroy($key)
    {
        $setting = $this->settingService->deleteSetting($key);

        if (!$setting) {
            return response()->json(['error' => 'Setting not found'], 404);
        }

        return response()->json(['message' => 'Setting deleted successfully'], 200);
    }
}