<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
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
        $restaurant = session('restaurant_id') ? Restaurant::find(session('restaurant_id')) : null;
        $restaurantName = $restaurant ? $restaurant->name : 'Ресторан';

        return $restaurantName.' | Категории';
    }

    public static function getModelLabel(): string
    {
        return 'Категория';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('restaurant_id')
                    ->default(session('restaurant_id'))
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
        $restaurantId = session('restaurant_id');

        if (! $restaurantId) {
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
            ->query(fn () => Category::query()->where('restaurant_id', $restaurantId))
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.categories.edit', [
                        'restaurant' => session('restaurant_id') ?? $record->restaurant_id,
                        'record' => $record->id,
                    ])),
            ])
            ->bulkActions([
                BulkAction::make('hide')
                    ->label('Скрыть')
                    ->action(function ($records) {
                        foreach ($records as $category) {
                            $category->update(['hidden' => true]);
                        }
                        Notification::make()
                            ->title('Успешно!')
                            ->body('Выбранные категории скрыты.')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('show')
                    ->label('Отобразить')
                    ->action(function ($records) {
                        foreach ($records as $category) {
                            $category->update(['hidden' => false]);
                        }

                        Notification::make()
                            ->title('Успешно!')
                            ->body('Выбранные категории отображены.')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
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
