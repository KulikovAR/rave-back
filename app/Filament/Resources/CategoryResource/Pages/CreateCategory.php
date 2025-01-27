<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Illuminate\Support\Facades\Log;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    public function getBreadcrumb(): string
    {
        return 'Создать категорию';
    }

    public function getTitle(): string
    {
        return 'Создание новой категории';
    }
}