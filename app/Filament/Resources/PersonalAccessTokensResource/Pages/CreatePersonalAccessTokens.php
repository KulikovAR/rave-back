<?php

namespace App\Filament\Resources\PersonalAccessTokensResource\Pages;

use App\Filament\Resources\PersonalAccessTokensResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonalAccessTokens extends CreateRecord
{
    protected static string $resource = PersonalAccessTokensResource::class;
}
