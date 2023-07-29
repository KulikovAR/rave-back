<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\TakeOutResource\Pages;
use App\Filament\Resources\TakeOutResource\RelationManagers;
use App\Models\Bank;
use App\Models\Order;
use App\Models\PartnerMessage;
use App\Models\TakeOut;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TakeOutResource extends Resource
{
    protected static ?string $model = TakeOut::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = MenuTitles::CATEGORY_REQUESTS;

    protected static ?string $pluralModelLabel = MenuTitles::MENU_TAKEOUTS;
    protected static ?string $modelLabel       = MenuTitles::MENU_TAKEOUT;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         //
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          //Tables\Columns\TextColumn::make('id'),
                          Tables\Columns\TextColumn::make('status'),
                          Tables\Columns\TextColumn::make('amount'),
                          Tables\Columns\TextColumn::make('amount_left'),
                          //Tables\Columns\TextColumn::make('takeoutable_id'),
                          //Tables\Columns\TextColumn::make('takeoutable_type'),
                          //Tables\Columns\TextColumn::make('user_id'),
                          //Tables\Columns\TextColumn::make('manager_id'),
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
                          Tables\Actions\ActionGroup::make([
                                                               Action::make('handle')
                                                                     ->action(function (TakeOut $record) {
                                                                         $record->manager_id = auth()->user()->id;
                                                                         $record->status     = Order::PROCESSING;
                                                                         $record->save();
                                                                     })
                                                                     ->label('Обработать')
                                                                     ->color('success')
                                                                     ->requiresConfirmation(),
                                                               Action::make('cancel')
                                                                     ->action(function (TakeOut $record) {
                                                                         $record->manager_id = null;
                                                                         $record->status     = Order::CREATED;
                                                                         $record->save();

                                                                     })
                                                                     ->label('Отказать')
                                                                     ->color('danger')
                                                                     ->requiresConfirmation()
                                                           ])
                      ])
            ->prependActions([
                                 Tables\Actions\Action::make('View user')
                                                      ->label('Юзер')
                                                      ->color('success')
                                                      ->icon('heroicon-s-user-circle')
                                                      ->url(fn($record): string => UserResource::getUrl('view', ['record' => $record->user])),

                                 Tables\Actions\Action::make('View takeout')
                                                      ->label('Реквизиты')
                                                      ->color('success')
                                                      ->icon('heroicon-s-cash')
                                                      ->url(function ($record): string {
                                                          $viewResource = 'App\Filament\Resources\CreditCardResource';
                                                          if ($record->takeoutable_type === Bank::class) {
                                                              $viewResource = 'App\Filament\Resources\BankResource';
                                                          }
                                                          return $viewResource::getUrl('view', ['record' => $record->takeoutable_id]);
                                                      })
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
            'index'  => Pages\ListTakeOuts::route('/'),
            'create' => Pages\CreateTakeOut::route('/create'),
            'edit'   => Pages\EditTakeOut::route('/{record}/edit'),
        ];
    }
}
