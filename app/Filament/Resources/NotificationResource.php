<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Filament\Resources\NotificationResource\RelationManagers;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserAppNotification;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\DatabaseNotification;
use Symfony\Component\Console\Input\Input;

class NotificationResource extends Resource
{
    protected static ?string $model = DatabaseNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->required()
                            ->options(User::all()->pluck('email', 'id'))
                            ->searchable(),

                        TextInput::make('data.message')
                            ->maxLength(255)
                            ->required()
                            ->translateLabel(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('id')
                                    ->toggleable(isToggledHiddenByDefault: true)
                                    ->searchable(),
                          TextColumn::make('type')
                                    ->toggleable(isToggledHiddenByDefault: true)
                                    ->sortable(),
                          TextColumn::make('notifiable')
                                    ->toggleable(isToggledHiddenByDefault: true),
                          TextColumn::make('data'),
                          TextColumn::make('read_at')
                                    ->dateTime()
                                    ->sortable(),
                          TextColumn::make('updated_at')
                                    ->dateTime()
                                    ->sortable(),
                      ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                          //
                      ])
            ->actions([
                          Tables\Actions\ActionGroup::make([
                                                               Tables\Actions\DeleteAction::make(),
                                                               Tables\Actions\EditAction::make(),
                                                           ])
                      ])
            ->prependActions([
                                 Tables\Actions\Action::make('View user')
                                                      ->label('Юзер')
                                                      ->color(fn($record) => $record->notifiable->hasRole(Role::ROLE_ADMIN) ? 'success' : 'default')
                                                      ->icon('heroicon-s-user-circle')
                                                      ->url(fn($record): string => UserResource::getUrl('view', ['record' => $record->notifiable->id])),
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
            'index'  => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'view'   => Pages\ViewNotification::route('/{record}'),
            'edit'   => Pages\EditNotification::route('/{record}/edit'),
        ];
    }


    public static function getModelLabel(): string
    {
        return __('admin-panel.notification');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin-panel.notifications');
    }

    public static function canEdit(Model $record): bool
    {
        return false;   
    }

    public static function canView(Model $record): bool
    {
        return false;
    }
}
