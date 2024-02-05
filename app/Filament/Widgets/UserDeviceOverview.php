<?php

namespace App\Filament\Widgets;

use App\Models\Role;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class UserDeviceOverview extends Widget
{
    protected static string $view = 'filament.widgets.user-device-overview';
    protected int|string|array $columnSpan = 2;

    const USER_DEVICE_COUNT_LIMIT = 5;

    public function render(): View
    {
        return view(static::$view, $this->getViewData(), [
            'users' => $this->getUserList()
        ]);
    }

    private function getUserList(): Collection
    {
        return User::whereHas('roles', function ($role) {
            $role->where('name', Role::ROLE_USER);
        })
            ->with('userProfile')
            ->withCount('userDevices')
            ->having('user_devices_count','>', self::USER_DEVICE_COUNT_LIMIT)
            ->orderBy('user_devices_count')
            ->limit(10)
            ->get();
    }
}
