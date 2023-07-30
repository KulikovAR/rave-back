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
                         Forms\Components\TextInput::make('patronymic')
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('country')
                                                   ->required()
                                                   ->maxLength(2),
                         Forms\Components\TextInput::make('gender')
                                                   ->required(),
                         Forms\Components\TextInput::make('document_number')
                                                   ->required()
                                                   ->maxLength(9),
                         Forms\Components\DateTimePicker::make('document_expires')
                                                        ->required(),
                         Forms\Components\TextInput::make('birthday')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('phone_prefix')
                                                   ->tel()
                                                   ->required()
                                                   ->maxLength(10),
                         Forms\Components\TextInput::make('phone')
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
                          Tables\Columns\TextColumn::make('patronymic'),
                          Tables\Columns\TextColumn::make('country'),
                          Tables\Columns\TextColumn::make('gender'),
                          Tables\Columns\TextColumn::make('document_number'),
                          Tables\Columns\TextColumn::make('document_expires'),
                          Tables\Columns\TextColumn::make('birthday'),
                          Tables\Columns\TextColumn::make('phone_prefix'),
                          Tables\Columns\TextColumn::make('phone'),
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
