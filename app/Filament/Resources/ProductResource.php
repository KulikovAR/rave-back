<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Товары';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Товары';
    }

    public static function getModelLabel(): string
    {
        return 'Товар';
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Hidden::make('restaurant_id')
                ->default(fn () => request('restaurant'))
                ->required(),

            Forms\Components\Select::make('category_id')
                ->label('Категория')
                ->options(function (callable $get) {
                    $restaurantId = $get('restaurant_id');
                    return \App\Models\Category::where('restaurant_id', $restaurantId)->pluck('name', 'id');
                })
                ->required(),

            Forms\Components\TextInput::make('name')
                ->label('Название')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('Описание')
                ->required(),
            Forms\Components\TextInput::make('price')
                ->label('Цена')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('weight')
                ->label('Вес')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('calories')
                ->label('Калории')
                ->numeric()
                ->required(),
            Forms\Components\Checkbox::make('hidden')
                ->label('Скрыть товар'),
            Forms\Components\Checkbox::make('new')
                ->label('Новый товар')
                ->default(true),
            Forms\Components\TextInput::make('priority')
                ->label('Приоритет')
                ->numeric()
                ->default(0),
            Forms\Components\Repeater::make('media')
                ->relationship('media')
                ->schema([
                    Forms\Components\FileUpload::make('path')
                        ->label('Изображение')
                        ->image(),
                ])
                ->label('Галерея изображений')
                ->columns(2),

            Forms\Components\Select::make('recommended_products')
                ->label('Рекомендованные товары')
                ->multiple()
                ->relationship('recommendedProducts', 'name') // Используем relationship для работы с Eloquent связью
                ->options(function (callable $get) {
                    $restaurantId = $get('restaurant_id');
                    return \App\Models\Product::whereHas('category', function ($query) use ($restaurantId) {
                        $query->where('restaurant_id', $restaurantId);
                    })->pluck('name', 'id');
                })
                ->preload(),
        ]);
}
    public static function table(Table $table): Table
{
    // Получаем ID ресторана из параметров запроса
    $restaurantId = request()->get('restaurant');

    if (!$restaurantId) {
        \Log::error('Restaurant ID not found in the query.');
        return $table;
    }

    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')->label('Название'),
            Tables\Columns\TextColumn::make('category.name')->label('Категория'),
            Tables\Columns\TextColumn::make('price')->label('Цена'),
            Tables\Columns\BooleanColumn::make('hidden')->label('Скрыт'),
            Tables\Columns\TextColumn::make('priority')->label('Приоритет'),
            Tables\Columns\BooleanColumn::make('new')
                ->label('Новый товар')
                ->trueIcon('heroicon-s-check')
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->url(fn ($record) => route('filament.admin.resources.products.edit', [
                    'restaurant' => request('restaurant'),
                    'record' => $record->id,
                ])),
        ])
        ->query(fn () => Product::query()
            ->whereHas('category', fn ($query) => $query->where('restaurant_id', $restaurantId))
        )
        ->defaultSort('priority', 'asc');
}

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{restaurant}/{record}/edit'),
        ];
    }
}