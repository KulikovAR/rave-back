<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankResource\Pages;
use App\Filament\Resources\BankResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Models\Bank;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

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
                         Forms\Components\TextInput::make('org_inn')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('org_kpp')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('org_ogrn')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('org_name')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('org_address')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('org_location')
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('contact_fio')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('contact_job')
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('contact_email')
                                                   ->email()
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('contact_tel')
                                                   ->tel()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('bank_bik')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('bank_user_account')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('bank_account')
                                                   ->required()
                                                   ->maxLength(255),
                         Forms\Components\TextInput::make('bank_name')
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
                          Tables\Columns\TextColumn::make('org_inn'),
                          Tables\Columns\TextColumn::make('org_kpp'),
                          Tables\Columns\TextColumn::make('org_ogrn'),
                          Tables\Columns\TextColumn::make('org_name'),
                          Tables\Columns\TextColumn::make('org_address'),
                          Tables\Columns\TextColumn::make('org_location'),
                          Tables\Columns\TextColumn::make('contact_fio'),
                          Tables\Columns\TextColumn::make('contact_job'),
                          Tables\Columns\TextColumn::make('contact_email'),
                          Tables\Columns\TextColumn::make('contact_tel'),
                          Tables\Columns\TextColumn::make('bank_bik'),
                          Tables\Columns\TextColumn::make('bank_user_account'),
                          Tables\Columns\TextColumn::make('bank_account'),
                          Tables\Columns\TextColumn::make('bank_name'),
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
            'index'  => Pages\ListBanks::route('/'),
            'view'   => Pages\ViewBank::route('/{record}'),
            'create' => Pages\CreateBank::route('/create'),
            'edit'   => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}
