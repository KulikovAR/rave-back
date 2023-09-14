<?php

namespace App\Filament\Resources\FaqTagResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\FaqTagResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaqTag extends BaseEditAction
{
    protected static string $resource = FaqTagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
