<?php

namespace App\Filament\Resources\PersonalAccessTokensResource\Pages;

use App\Filament\Resources\PersonalAccessTokensResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalAccessTokens extends ViewRecord
{
    protected static string $resource = PersonalAccessTokensResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
