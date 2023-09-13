<?php

namespace App\Filament\Resources\PersonalAccessTokensResource\Pages;

use App\Filament\Resources\PersonalAccessTokensResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersonalAccessTokens extends ListRecords
{
    protected static string $resource = PersonalAccessTokensResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
