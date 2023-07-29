<?php

namespace App\Filament\Resources\CreditCardResource\Pages;

use App\Filament\Resources\CreditCardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditCard extends EditRecord
{
    protected static string $resource = CreditCardResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
