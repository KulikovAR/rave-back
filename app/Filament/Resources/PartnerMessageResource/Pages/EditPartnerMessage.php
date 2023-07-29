<?php

namespace App\Filament\Resources\PartnerMessageResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\PartnerMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerMessage extends BaseEditAction
{
    protected static string $resource = PartnerMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
