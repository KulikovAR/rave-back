<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProfileResource\Pages;
use App\Filament\Resources\UserProfileResource\RelationManagers;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class UserProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Select::make('user_id')
                               ->relationship('user', 'email')
                               ->required(),
                         TextInput::make('firstname')
                                  ->required()
                                  ->maxLength(255),

                         TextInput::make('lastname')
                                  ->required()
                                  ->maxLength(255),

                         TextInput::make('avatar'),

                         DateTimePicker::make('created_at')->default(now()),
                         DateTimePicker::make('updated_at')->default(now()),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('id')
                                                   ->toggleable(isToggledHiddenByDefault: true)
                                                   ->searchable(),

                          TextColumn::make('user.email')
                                                   ->toggleable(isToggledHiddenByDefault: true)
                                                   ->searchable(),

                          TextColumn::make('firstname')
                                                   ->toggleable(isToggledHiddenByDefault: false)
                                                   ->searchable(),

                          TextColumn::make('lastname')
                                                   ->toggleable(isToggledHiddenByDefault: false)
                                                   ->searchable(),

                          TextColumn::make('avatar')
                                                   ->toggleable(isToggledHiddenByDefault: true),

                          TextColumn::make('created_at')
                                                   ->toggleable(isToggledHiddenByDefault: true)
                                                   ->sortable()
                                                   ->dateTime(),

                          TextColumn::make('updated_at')
                                                   ->toggleable(isToggledHiddenByDefault: false)
                                                   ->sortable()
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
