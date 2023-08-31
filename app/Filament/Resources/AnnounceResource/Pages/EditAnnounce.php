<?php

namespace App\Filament\Resources\AnnounceResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\AnnounceResource;
use Filament\Pages\Actions;

class EditAnnounce extends BaseEditAction
{
    protected static string $resource = AnnounceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
