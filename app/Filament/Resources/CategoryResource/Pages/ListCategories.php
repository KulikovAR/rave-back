<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        \Log::info('Creating new category header action', ['restaurant' => request('restaurant')]);

        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.categories.create') . '?restaurant=' . request('restaurant')),
        ];
    }

    public function getTitle(): string
    {
        return 'Список категорий';
    }

    public function getBreadcrumb(): string
    {
        return 'Список';
    }
}