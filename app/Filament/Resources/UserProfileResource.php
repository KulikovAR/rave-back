<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProfileResource\Pages;
use App\Filament\Resources\UserProfileResource\RelationManagers;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UserProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Forms\Components\Select::make('user_id')
                                                ->relationship('user', 'email')
                                                ->required(),
                         Forms\Components\TextInput::make('firstname')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('lastname')
                                                   ->required()
                                                   ->maxLength(255),

                         DateTimePicker::make('created_at')->default(now()),
                         DateTimePicker::make('updated_at')->default(now()),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('id'),
                          Tables\Columns\TextColumn::make('user.name'),
                          Tables\Columns\TextColumn::make('firstname'),
                          Tables\Columns\TextColumn::make('lastname'),
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
            'index'  => Pages\ListUserProfiles::route('/'),
            'create' => Pages\CreateUserProfile::route('/create'),
            'edit'   => Pages\EditUserProfile::route('/{record}/edit'),
        ];
    }


}
