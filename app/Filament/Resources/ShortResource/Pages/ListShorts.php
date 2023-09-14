<?php

namespace App\Filament\Resources\ShortResource\Pages;

use App\Filament\Resources\ShortResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShorts extends ListRecords
{
    protected static string $resource = ShortResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
