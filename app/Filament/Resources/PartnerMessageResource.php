<?php

namespace App\Filament\Resources;

use App\Events\PartnerMessageEvent;
use App\Filament\MenuTitles;
use App\Filament\Resources\PartnerMessageResource\Pages;
use App\Filament\Resources\PartnerMessageResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\PartnerMessage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerMessageResource extends Resource
{
    protected static ?string $model = PartnerMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = MenuTitles::CATEGORY_REQUESTS;

    protected static ?string $pluralModelLabel = MenuTitles::MENU_PARTNERS;
    protected static ?string $modelLabel       = MenuTitles::MENU_PARTNER;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Forms\Components\TextInput::make('id')
                                                   ->disabled(),
                         Forms\Components\Select::make('user_id')
                                                ->relationship('user', 'id')
                                                ->disabled(),
                         Forms\Components\TextInput::make('link_location')
                                                   ->disabled(),
                         Forms\Components\Toggle::make('approved')
                                                ->required(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          //Tables\Columns\TextColumn::make('id'),
                          Tables\Columns\TextColumn::make('user.id'),
                          Tables\Columns\TextColumn::make('link_location'),
                          Tables\Columns\IconColumn::make('approved')
                                                   ->boolean(),
                          Tables\Columns\TextColumn::make('created_at')
                                                   ->dateTime(),
                          Tables\Columns\TextColumn::make('updated_at')
                                                   ->dateTime(),
                      ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                          //
                      ])
            ->actions([
                          EditAction::make(),
                          ActionGroup::make([
                                                Action::make('approve')
                                                      ->action(function (PartnerMessage $record) {
                                                          event(new PartnerMessageEvent($record));
                                                      })
                                                      ->label('Принять')
                                                      ->color('success')
                                                      ->requiresConfirmation(),
                                                Action::make('cancel')
                                                      ->action(function (PartnerMessage $record) {
                                                          $record->approved = false;
                                                          $record->save();

                                                          $record->user()->update(['is_partner' => false]);
                                                      })
                                                      ->label('Отказать')
                                                      ->color('danger')
                                                      ->requiresConfirmation()
                                            ])
                      ])
            ->prependActions([
                                 Tables\Actions\Action::make('View user')
                                                      ->color('success')
                                                      ->icon('heroicon-s-view-list')
                                                      ->url(fn($record): string => UserResource::getUrl('view', ['record' => $record->user]))
                             ])
            ->bulkActions([
                              DeleteBulkAction::make(),
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
            'index' => Pages\ListPartnerMessages::route('/'),
            //'create' => Pages\CreatePartnerMessage::route('/create'),
            'edit'  => Pages\EditPartnerMessage::route('/{record}/edit'),
        ];
    }
}
