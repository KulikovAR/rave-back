<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getRedirectUrl(): string
    {
        return url()->previous() ?? route('filament.admin.resources.orders.index', [
            'restaurant' => request()->get('restaurant'),
        ]);
    }

    public function getBreadcrumb(): string
    {
        return 'Создать заказ';
    }

    public function getTitle(): string
    {
        return 'Создание нового заказа';
    }
}
