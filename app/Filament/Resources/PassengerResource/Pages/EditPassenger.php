<?php

namespace App\Filament\Resources\PassengerResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\PassengerResource;
use Filament\Pages\Actions;

class EditPassenger extends BaseEditAction
{
    protected static string $resource = PassengerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
