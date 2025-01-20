<?php

namespace App\Http\Services;

use App\Models\Setting;

class SettingService
{
    public function getAllSettings()
    {
        return Setting::all();
    }

    public function getSettingByKey($key)
    {
        return Setting::where('key', $key)->first();
    }

    public function createSetting(array $data)
    {
        return Setting::create($data);
    }

    public function updateSetting($key, array $data)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting->update($data);
        }

        return $setting;
    }

    public function deleteSetting($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting->delete();
        }

        return $setting;
    }
}
