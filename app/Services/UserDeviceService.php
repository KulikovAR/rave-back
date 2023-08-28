<?php

namespace App\Services;

use App\Http\Resources\Device\DevicesCollection;
use App\Models\User;
use DeviceDetector\Parser\Client\Browser;

class UserDeviceService
{
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }


    public function checkTooManyDevices(string $device_name): bool {
        if (empty($device_name)) {
            $device_name = 'spa';
        }

        $token = $this->user->tokens()->where('name', $device_name)->first();

        if(!is_null($token)) {
            return false;
        }

        return $this->user->tokens()->count() >= config('tokens.devices_available_quantity');
    }

    public function getDevices()
    {
        return new DevicesCollection($this->user->tokens);
    }

    public function deleteDeviceByName(string $device_name): bool
    {
        return $this->user->tokens()->where('name', $device_name)->delete();
    }
}