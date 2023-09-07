<?php

namespace App\Services;

use App\Http\Resources\Device\DevicesCollection;
use App\Models\User;
use DeviceDetector\Parser\Client\Browser;

class UserDeviceService
{
    protected $user;
    protected $device_name;

    public function __construct(User $user, string $device_name = '') {
        $this->user = $user;
        $this->device_name = $device_name;
    }


    public function checkTooManyDevices(): bool {
        if (empty($this->device_name)) {
            $this->device_name = 'spa';
        }

        $token = $this->user->tokens()->where('temp', false)->where('name', $this->device_name)->first();

        if(!is_null($token)) {
            return false;
        }

        return $this->user->tokens()->where('temp', false)->count() >= config('tokens.devices_available_quantity');
    }

    public function checkTempToken(): bool
    {
        $token = $this->user->tokens()->where('temp', true)->where('name', $this->device_name)->first();

        if (!is_null($token)) {
            return true;
        }

        return false;
    }
    
    public function getDevices()
    {
        return new DevicesCollection($this->user->tokens()->where('temp',false)->get());
    }

    public function deleteDeviceByName(string $device_name_to_delete): bool
    {
        $this->user->tokens()->where('name', $this->device_name)->update([
            'temp' => false
        ]);

        return $this->user->tokens()->where('name', $device_name_to_delete)->delete();
    }
}