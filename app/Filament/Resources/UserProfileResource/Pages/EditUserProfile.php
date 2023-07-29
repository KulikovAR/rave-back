<?php

namespace App\Filament\Resources\UserProfileResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\UserProfileResource;
use Filament\Pages\Actions;

class EditUserProfile extends BaseEditAction
{
    protected static string $resource = UserProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
