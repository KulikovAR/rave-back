<?php

namespace App\Filament\Resources\PersonalAccessTokensResource\Pages;

use App\Filament\Resources\PersonalAccessTokensResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalAccessTokens extends EditRecord
{
    protected static string $resource = PersonalAccessTokensResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
