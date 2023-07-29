<?php

namespace App\Filament\Resources\PartnerMessageResource\Pages;

use App\Filament\Resources\PartnerMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartnerMessages extends ListRecords
{
    protected static string $resource = PartnerMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
