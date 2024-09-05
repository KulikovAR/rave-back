<?php

namespace App\Filament\Resources\OrderPassengerResource\Pages;

use App\Filament\Resources\OrderPassengerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderPassengers extends ListRecords
{
    protected static string $resource = OrderPassengerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
