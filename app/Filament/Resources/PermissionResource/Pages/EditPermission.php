<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\PermissionResource;
use Filament\Pages\Actions;

class EditPermission extends BaseEditAction
{
    protected static string $resource = PermissionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
