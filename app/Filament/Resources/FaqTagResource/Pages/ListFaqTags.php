<?php

namespace App\Filament\Resources\FaqTagResource\Pages;

use App\Filament\Resources\FaqTagResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaqTags extends ListRecords
{
    protected static string $resource = FaqTagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
