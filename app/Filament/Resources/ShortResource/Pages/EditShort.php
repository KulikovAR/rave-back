<?php

namespace App\Filament\Resources\ShortResource\Pages;

use App\Filament\Resources\ShortResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShort extends EditRecord
{
    protected static string $resource = ShortResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
