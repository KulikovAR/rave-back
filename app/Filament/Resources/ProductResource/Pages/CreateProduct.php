<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function getBreadcrumb(): string
    {
        return 'Создать товар';
    }

    public function getTitle(): string
    {
        return 'Создание нового товара';
    }
}
