<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    public function mount(): void
    {
        $restaurantId = request()->get('restaurant');
        if ($restaurantId) {
            session(['restaurant_id' => $restaurantId]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.orders.create').'?restaurant='.request('restaurant')),
        ];
    }

    public function getTitle(): string
    {
        return 'Список заказов';
    }

    public function getBreadcrumb(): string
    {
        return 'Список';
    }
}
