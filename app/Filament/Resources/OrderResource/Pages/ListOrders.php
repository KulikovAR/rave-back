<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        \Log::info('Creating new category header action', ['restaurant' => request('restaurant')]);

        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.orders.create') . '?restaurant=' . request('restaurant')),
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
