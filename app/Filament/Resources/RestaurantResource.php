<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function getNavigationLabel(): string
    {
        return 'Рестораны';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Рестораны';
    }

    public static function getModelLabel(): string
    {
        return 'Ресторан';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Forms\Components\FileUpload::make('photo')
                    ->label('Фото')
                    ->image(),
                Forms\Components\TextInput::make('priority')
                    ->label('Приоритет')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Название'),
                Tables\Columns\ImageColumn::make('photo')->label('Фото'),
                Tables\Columns\TextColumn::make('priority')->label('Приоритет'),
            ])
            ->defaultSort('priority', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }
}
