<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

    public function getBreadcrumb(): string
    {
        return 'Создать баннер';
    }

    public function getTitle(): string
    {
        return 'Создание нового баннера';
    }
}
