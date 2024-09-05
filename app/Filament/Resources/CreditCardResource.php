<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditCardResource\Pages;
use App\Filament\Resources\CreditCardResource\RelationManagers;
use App\Models\CreditCard;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CreditCardResource extends Resource
{
    protected static ?string $model = CreditCard::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Forms\Components\TextInput::make('id')
                                                   ->required()
                                                   ->maxLength(36),
                         Forms\Components\Select::make('user_id')
                                                ->relationship('user', 'id')
                                                ->required(),
                         Forms\Components\TextInput::make('card_number')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('card_bank_name')
                                                   ->required()
                                                   ->maxLength(255),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('id'),
                          Tables\Columns\TextColumn::make('user.id'),
                          Tables\Columns\TextColumn::make('card_number'),
                          Tables\Columns\TextColumn::make('card_bank_name'),
                          Tables\Columns\TextColumn::make('created_at')
                                                   ->dateTime(),
                          Tables\Columns\TextColumn::make('updated_at')
                                                   ->dateTime(),
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
            'index'  => Pages\ListCreditCards::route('/'),
            'view'   => Pages\ViewCreditCard::route('/{record}'),
            'create' => Pages\CreateCreditCard::route('/create'),
            'edit'   => Pages\EditCreditCard::route('/{record}/edit'),
        ];
    }
}
