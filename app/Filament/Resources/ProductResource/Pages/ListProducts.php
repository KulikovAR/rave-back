<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public function mount(): void
    {
        $restaurantId = request()->get('restaurant');
        if ($restaurantId) {
            session(['restaurant_id' => $restaurantId]);
        }
    }

    public function updateRecordsPerPage($recordsPerPage)
    {
        $restaurantId = session('restaurant_id');

        if (! $restaurantId) {
            return;
        }

        $this->recordsPerPage = $recordsPerPage;

        $this->emit('updateTable', ['restaurant' => session('restaurant_id'), 'recordsPerPage' => $this->recordsPerPage]);
    }

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.products.create').'?restaurant='.request('restaurant')),
        ];
    }

    public function getTitle(): string
    {
        return 'Список товаров';
    }

    public function getBreadcrumb(): string
    {
        return 'Список';
    }
}
