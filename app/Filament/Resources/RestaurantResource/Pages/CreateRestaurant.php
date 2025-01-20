<?php

namespace App\Filament\Resources\RestaurantResource\Pages;

use App\Filament\Resources\RestaurantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRestaurant extends CreateRecord
{
    protected static string $resource = RestaurantResource::class;

    public function getBreadcrumb(): string
    {
        return 'Создать ресторан';
    }

    public function getTitle(): string
    {
        return 'Создание нового ресторана';
    }
}
