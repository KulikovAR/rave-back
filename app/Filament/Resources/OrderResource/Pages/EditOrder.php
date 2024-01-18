<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\OrderResource;
use Filament\Pages\Actions;

class EditOrder extends BaseEditAction
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
