<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\MenuTitles;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class UserProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'userProfile';

    protected static ?string $recordTitleAttribute = 'lastname';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Forms\Components\TextInput::make('firstname')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('lastname')
                                                   ->required()
                                                   ->maxLength(255)
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('firstname'),
                          Tables\Columns\TextColumn::make('lastname'),
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
                          ActionGroup::make([
                                                ViewAction::make(),
                                                EditAction::make(),
                                                DeleteAction::make(),
                                            ])
                      ])
            ->bulkActions([
                              Tables\Actions\DeleteBulkAction::make(),
                          ])
            ->appendHeaderActions([
                                      Tables\Actions\CreateAction::make()
                                  ]);
    }
}
