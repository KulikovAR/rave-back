<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use App\Models\Permission;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup  = MenuTitles::CATEGORY_SETTINGS;
    protected static ?string $pluralModelLabel = MenuTitles::MENU_PERMISSIONS;
    protected static ?string $modelLabel       = MenuTitles::MENU_PERMISSION;


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
                          Tables\Actions\DeleteAction::make(),
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
            'index'  => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit'   => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
