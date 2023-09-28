<?php

namespace App\Filament\Resources;

use App\Enums\SubscriptionTypeEnum;
use App\Filament\MenuTitles;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\RelationManagers\OrderRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\PassengerRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\QuizResultsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\UserProfileRelationManager;
use App\Models\Order;
use App\Models\Role;
use App\Models\TakeOut;
use App\Models\User;
use Filament\Forms\Components\Checkbox;
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
use Filament\Forms\Components\DatePicker;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon   = 'heroicon-o-user-circle';
    protected static ?string $pluralModelLabel = MenuTitles::MENU_USERS;
    protected static ?string $modelLabel       = MenuTitles::MENU_USER;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('email')
                                  ->email()
                                  ->unique(ignoreRecord: true)
                                  ->required()
                                  ->maxLength(255),

                         Select::make('lessons')
                               ->multiple()
                               ->relationship('lessons', 'title')
                               ->searchable(),

                         Select::make('subscription_type')->options(SubscriptionTypeEnum::allValuesWithDescription()),
                         DateTimePicker::make('subscription_expires_at'),
                         DateTimePicker::make('subscription_created_at'),
                         DateTimePicker::make('last_video_added_at'),

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
                               
                         Checkbox::make('is_blocked'),

                         DateTimePicker::make('email_verified_at'),
                         DateTimePicker::make('created_at')->disabled(),
                         DateTimePicker::make('updated_at')->disabled(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('id')
                                    ->searchable()
                                    ->toggleable(isToggledHiddenByDefault: true),
                          TextColumn::make('name')
                                    ->searchable()
                                    ->toggleable(isToggledHiddenByDefault: true),
                          TextColumn::make('email')
                                    ->toggleable(isToggledHiddenByDefault: false)
                                    ->searchable(),
                          IconColumn::make('email_verified_at')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-mail-open')
                                    ->falseIcon('heroicon-o-mail'),
                          IconColumn::make('is_blocked')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->trueColor('success')
                                    ->falseIcon('heroicon-o-ban')
                                    ->falseColor('danger')
                                    ->alignCenter(),
                          TextColumn::make('roles.name')
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: false),
                          //TextColumn::make('salt'),
                          TextColumn::make('language')
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),
                          TextColumn::make('auto_subscription')
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: false),
                          TextColumn::make('subscription_type')
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: false),
                          TextColumn::make('subscription_expires_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),

                          TextColumn::make('subscription_created_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),

                          TextColumn::make('last_video_added_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),

                          TextColumn::make('created_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),

                          TextColumn::make('created_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: false),

                          TextColumn::make('updated_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: false),
                          IconColumn::make('deleted_at')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-ban')
                                    ->trueColor('danger')
                                    ->toggleable(isToggledHiddenByDefault: true),
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
            QuizResultsRelationManager::class,
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