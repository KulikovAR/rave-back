<?php

namespace App\Filament\Resources\TakeOutResource\Pages;

use App\Filament\Resources\TakeOutResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTakeOuts extends ListRecords
{
    protected static string $resource = TakeOutResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
