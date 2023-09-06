<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\PriceResource\Pages;
use App\Filament\Resources\PriceResource\RelationManagers;
use App\Models\Price;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceResource extends Resource
{
    protected static ?string $model = Price::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = MenuTitles::CATEGORY_APP;
    protected static ?string $pluralModelLabel = 'Прайсы';
    protected static ?string $modelLabel = 'Прайс';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('price_normal')
                    ->integer()
                    ->required(),
                TextInput::make('price_vip')
                    ->integer()
                    ->required(),
                TextInput::make('price_premium')
                    ->integer()
                    ->required(),
                TextInput::make('duration_normal')
                    ->integer()
                    ->required(),
                TextInput::make('duration_vip')
                    ->integer()
                    ->required(),
                TextInput::make('duration_premium')
                    ->integer()
                    ->required(),
                TextInput::make('value')
                    ->required(),
                // Select::make('locale')
                //     ->options(config('site-values.locales'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('price_normal'),
                TextColumn::make('price_vip'),
                TextColumn::make('price_premium'),
                TextColumn::make('price_premium'),
                TextColumn::make('duration_normal'),
                TextColumn::make('duration_vip'),
                TextColumn::make('duration_premium'),
                TextColumn::make('value'),
                TextColumn::make('locale')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListPrices::route('/'),
            // 'create' => Pages\CreatePrice::route('/create'),
            'edit'  => Pages\EditPrice::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}