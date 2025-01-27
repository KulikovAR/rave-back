<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Категории';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Категории';
    }

    public static function getModelLabel(): string
    {
        return 'Категория';
    }

    public static function form(Form $form): Form
    {
        // Логируем запрос
        \Log::info('Restaurant ID from URL', ['restaurant' => request('restaurant')]);

        return $form
            ->schema([
                // Скрытое поле для restaurant_id
                Forms\Components\Hidden::make('restaurant_id')
                    ->default(request('restaurant'))  // Берем restaurant_id из query-параметра
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),

                Forms\Components\Checkbox::make('hidden')
                    ->label('Скрыть категорию'),

                Forms\Components\TextInput::make('priority')
                    ->label('Приоритет')
                    ->numeric()
                    ->default(0),

                Forms\Components\FileUpload::make('image')
                    ->label('Изображение категории')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $restaurantId = request()->get('restaurant');
        \Log::info('Restaurant ID from query', ['restaurant' => $restaurantId]);

        if (!$restaurantId) {
            throw new \RuntimeException('Параметр restaurant не передан в запросе.');
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Название'),
                Tables\Columns\BooleanColumn::make('hidden')->label('Скрыта'),
                Tables\Columns\TextColumn::make('priority')->label('Приоритет'),
                Tables\Columns\ImageColumn::make('image')->label('Изображение'),
            ])
            ->defaultSort('priority', 'asc')
            ->query(fn () => Category::query()->where('restaurant_id', $restaurantId));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}