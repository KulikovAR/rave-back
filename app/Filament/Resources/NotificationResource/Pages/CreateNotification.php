<?php

namespace App\Filament\Resources\NotificationResource\Pages;

use App\Filament\Resources\NotificationResource;
use App\Models\User;
use App\Notifications\UserAppNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::findOrFail($data['user_id']);

        $user->notify(new UserAppNotification($data['data']['message']));

        return $user->notifications()->orderBy('created_at', 'desc')->first();
    }
}
