<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\RoleResource;
use Filament\Pages\Actions;

class EditRole extends BaseEditAction
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
