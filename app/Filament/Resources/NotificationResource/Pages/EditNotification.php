<?php

namespace App\Filament\Resources\NotificationResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\NotificationResource;
use Filament\Pages\Actions;

class EditNotification extends BaseEditAction
{
    protected static string $resource = NotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
