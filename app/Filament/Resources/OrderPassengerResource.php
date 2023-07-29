<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderPassengerResource\Pages;
use App\Filament\Resources\OrderPassengerResource\RelationManagers;
use App\Models\OrderPassenger;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderPassengerResource extends Resource
{
    protected static ?string $model = OrderPassenger::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                         Forms\Components\Textarea::make('firstname')
                                                  ->required()
                                                  ->maxLength(65535),
                         Forms\Components\Textarea::make('lastname')
                                                  ->required()
                                                  ->maxLength(65535),
                         Forms\Components\TextInput::make('patronymic')
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('country')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('gender')
                                                   ->required(),
                         Forms\Components\Textarea::make('document_number')
                                                  ->required()
                                                  ->maxLength(65535),
                         Forms\Components\Textarea::make('document_expires')
                                                  ->maxLength(65535),
                         Forms\Components\Textarea::make('birthday')
                                                  ->required()
                                                  ->maxLength(65535),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('firstname'),
                          Tables\Columns\TextColumn::make('lastname'),
                          Tables\Columns\TextColumn::make('patronymic'),
                          Tables\Columns\TextColumn::make('country'),
                          Tables\Columns\TextColumn::make('gender'),
                          Tables\Columns\TextColumn::make('document_number'),
                          Tables\Columns\TextColumn::make('document_expires'),
                          Tables\Columns\TextColumn::make('birthday'),
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
                          Tables\Actions\ViewAction::make(),
                      ])
            ->bulkActions([
                              Tables\Actions\DeleteBulkAction::make(),
                          ])
            ->appendHeaderActions([
                                      CreateAction::make()
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
            'index'  => Pages\ListOrderPassengers::route('/'),
            'create' => Pages\CreateOrderPassenger::route('/create'),
            'edit'   => Pages\EditOrderPassenger::route('/{record}/edit'),
        ];
    }
}
