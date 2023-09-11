<?php

namespace App\Filament\Resources\BannerResource\Pages;

use Filament\Pages\Actions;
use App\Filament\BaseEditAction;
use App\Filament\Resources\BannerResource;

class EditBanner extends BaseEditAction
{
    protected static string $resource = BannerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
