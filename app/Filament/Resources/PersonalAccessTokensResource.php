<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalAccessTokensResource\Pages;
use App\Filament\Resources\PersonalAccessTokensResource\RelationManagers;
use App\Models\PersonalAccessTokens;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonalAccessTokensResource extends Resource
{
    protected static ?string $model = PersonalAccessTokens::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tokenable_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tokenable_id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\Textarea::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('temp')
                    ->required(),
                Forms\Components\TextInput::make('token')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('abilities')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('last_used_at'),
                Forms\Components\DateTimePicker::make('expires_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tokenable_type')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tokenable_id')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->tooltip(fn($record) => $record->tokenable_id)
                    ->limit(15)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->tooltip(fn($record) => $record->name)
                    ->limit(15)
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('temp')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->boolean(),
                TextColumn::make('token')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('abilities')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_used_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('expires_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->prependActions([
                Tables\Actions\Action::make('View user')
                    ->label('Юзер')
                    ->color('success')
                    ->icon('heroicon-s-user-circle')
                    ->url(fn($record): string => UserResource::getUrl('view', ['record' => $record->tokenable_id])),
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
            'index' => Pages\ListPersonalAccessTokens::route('/'),
            //'create' => Pages\CreatePersonalAccessTokens::route('/create'),
            'view' => Pages\ViewPersonalAccessTokens::route('/{record}'),
            //'edit' => Pages\EditPersonalAccessTokens::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('admin-panel.token');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin-panel.tokens');
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    protected static function getNavigationGroup(): string
    {
        return __('admin-panel.settings');
    }
}
