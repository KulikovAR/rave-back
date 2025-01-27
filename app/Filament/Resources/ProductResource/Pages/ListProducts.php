<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.products.create') . '?restaurant=' . request('restaurant')),
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