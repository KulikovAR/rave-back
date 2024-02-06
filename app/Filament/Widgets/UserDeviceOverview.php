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
        return User::select('users.*')
            ->whereHas('roles', function ($role) {
                $role->where('name', Role::ROLE_USER);
            })
            ->selectRaw('COUNT(user_devices.id) as user_devices_count')
            ->leftJoin('user_devices', 'users.id', '=', 'user_devices.user_id')
            ->groupBy('users.id')
            ->havingRaw('COUNT(user_devices.id) >= ' . self::USER_DEVICE_COUNT_LIMIT)
            ->orderBy('user_devices_count', 'desc')
            ->get();
    }
}
