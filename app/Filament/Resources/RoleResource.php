<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup  = MenuTitles::CATEGORY_SETTINGS;
    protected static ?string $pluralModelLabel = MenuTitles::MENU_ROLES;
    protected static ?string $modelLabel       = MenuTitles::MENU_ROLE;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('name')
                                  ->unique(ignoreRecord: true)
                                  ->required()
                                  ->maxLength(255),
                         TextInput::make('guard_name')
                                  ->required()
                                  ->maxLength(255)
                                  ->default('web'),
                         Select::make('permissions')
                               ->multiple()
                               ->relationship('permissions', 'name')
                               ->preload(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('name'),
                          Tables\Columns\TextColumn::make('guard_name'),
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
            'index'  => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit'   => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
