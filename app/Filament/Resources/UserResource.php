<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\RelationManagers\OrderRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\PassengerRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\UserProfileRelationManager;
use App\Models\Order;
use App\Models\Role;
use App\Models\TakeOut;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon   = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup  = MenuTitles::CATEGORY_APP;
    protected static ?string $pluralModelLabel = MenuTitles::MENU_USERS;
    protected static ?string $modelLabel       = MenuTitles::MENU_USER;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('name')
                                  ->maxLength(255),
                         TextInput::make('email')
                                  ->email()
                                  ->unique(ignoreRecord: true)
                                  ->required()
                                  ->maxLength(255),
                         TextInput::make('password')
                                  ->password()
                                  ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                  ->dehydrated(fn($state) => filled($state))
                                  ->required(fn(string $context): bool => $context === 'create')
                                  ->maxLength(255),
                         Select::make('roles')
                               ->required()
                               ->multiple()
                               ->relationship('roles', 'name', function () {
                                   if (auth()->user()->hasRole(Role::ROLE_MANAGER))
                                       return Role::where(['name' => Role::ROLE_USER]);
                               })
                               ->preload(),
                         TextInput::make('language')
                                  ->maxLength(2),
                         DateTimePicker::make('created_at')->disabled(),
                         DateTimePicker::make('updated_at')->disabled(),
                         DateTimePicker::make('deleted_at')->disabled(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('id'),
                          TextColumn::make('name'),
                          TextColumn::make('email')->searchable(),
                          IconColumn::make('email_verified_at')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-mail-open')
                                    ->falseIcon('heroicon-o-mail'),
                          TextColumn::make('roles.name'),
                          //TextColumn::make('salt'),
                          TextColumn::make('language'),
                          TextColumn::make('created_at')
                                    ->dateTime()
                                    ->sortable(),
                          TextColumn::make('updated_at')
                                    ->dateTime()
                                    ->sortable(),
                          IconColumn::make('deleted_at')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-ban')
                                    ->trueColor('danger'),
                      ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                          TrashedFilter::make(),
                      ])
            ->actions([
                          ActionGroup::make([
                                                ViewAction::make(),
                                                EditAction::make(),
                                                DeleteAction::make(),
                                            ])
                      ])
            ->bulkActions([
                              DeleteBulkAction::make(),
                              ForceDeleteBulkAction::make(),
                              RestoreBulkAction::make(),
                          ]);
    }

    public static function getRelations(): array
    {
        return [
            UserProfileRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view'   => ViewUser::route('/{record}'),
            'edit'   => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole(Role::ROLE_ADMIN)
            ? parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class])
            : User::role(Role::ROLE_USER);
    }

    protected function getTableRecordActionUsing(): ?Closure
    {
        return fn(): string => 'view';
    }
}
