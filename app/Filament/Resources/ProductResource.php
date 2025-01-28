<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;

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
        $restaurant = session('restaurant_id') ? Restaurant::find(session('restaurant_id')) : null;
        $restaurantName = $restaurant ? $restaurant->name : 'Ресторан';

        return $restaurantName.' | Товары';
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
                    ->default(fn () => session('restaurant_id'))
                    ->required(),

                Forms\Components\Select::make('category_id')
                    ->label('Категория')
                    ->options(function (callable $get) {
                        $restaurantId = session('restaurant_id');

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
                    ->relationship('recommendedProducts', 'name')
                    ->options(function (callable $get) {
                        $restaurantId = session('restaurant_id');

                        return \App\Models\Product::whereHas('category', function ($query) use ($restaurantId) {
                            $query->where('restaurant_id', $restaurantId);
                        })->pluck('name', 'id');
                    })
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {

        $restaurantId = session('restaurant_id');

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Название'),
                Tables\Columns\TextColumn::make('category.name')->label('Категория'),
                Tables\Columns\TextColumn::make('price')->label('Цена'),
                Tables\Columns\BooleanColumn::make('hidden')->label('Скрыт'),
                Tables\Columns\TextColumn::make('priority')->label('Приоритет'),
                Tables\Columns\BooleanColumn::make('new')
                    ->label('Новый товар')
                    ->trueIcon('heroicon-s-check'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.products.edit', [
                        'restaurant' => session('restaurant_id') ?? $record->category->restaurant_id,
                        'record' => $record->id,
                    ])),
            ])
            ->bulkActions([
                BulkAction::make('hide')
                    ->label('Скрыть')
                    ->action(function ($records) {
                        foreach ($records as $product) {
                            $product->update(['hidden' => true]);
                        }
                        Notification::make()
                            ->title('Успешно!')
                            ->body('Выбранные товары скрыты.')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('show')
                    ->label('Отобразить')
                    ->action(function ($records) {
                        foreach ($records as $product) {
                            $product->update(['hidden' => false]);
                        }
                        Notification::make()
                            ->title('Успешно!')
                            ->body('Выбранные товары отображены.')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('delete')
                    ->label('Удалить')
                    ->action(function ($records) {
                        foreach ($records as $product) {
                            $product->delete();
                        }
                        Notification::make()
                            ->title('Успешно!')
                            ->body('Выбранные товары удалены.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Удаление товаров')
                    ->modalSubheading('Вы уверены, что хотите удалить выбранные товары? Это действие нельзя отменить.')
                    ->modalButton('Удалить')
                    ->deselectRecordsAfterCompletion(),
            ])
            ->query(fn () => Product::query()
            ->whereHas('category', fn ($query) => $query->where('restaurant_id', session('restaurant_id')))
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name')
            ->orderBy('products.priority')
            ->orderBy('products.name')
            ->select('products.*')
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
