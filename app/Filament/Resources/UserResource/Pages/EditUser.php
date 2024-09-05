<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;

class EditUser extends BaseEditAction
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
