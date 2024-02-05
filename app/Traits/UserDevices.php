<?php

namespace App\Traits;

use App\Models\UserDevices as ModelsUserDevices;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserDevices
{
    public function userDevices(): HasMany
    {
        return $this->hasMany(ModelsUserDevices::class);
    }

    public function addDevice(string $userAgent): ModelsUserDevices
    {
        $data = [
            'user_id' => $this->id,
            'userAgent' => $userAgent
        ];

        return ModelsUserDevices::createOrUpdate($data, $data);
    }

    public function getDeviceCount(): int
    {
        return $this->userDevices()->count();
    }
}