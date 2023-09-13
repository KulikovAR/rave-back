<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\SettingResource;
use Filament\Pages\Actions;

class EditSetting extends BaseEditAction
{
    protected static string $resource = SettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
