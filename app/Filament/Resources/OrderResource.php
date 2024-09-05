<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\OrderPassengerResource\RelationManagers\OrdersPassengerRelationManager;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\UserProfile;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup  = 'Приложение';
    protected static ?string $pluralModelLabel = 'Заказы';
    protected static ?string $modelLabel       = 'Заказa';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Select::make('user_id')
                               ->relationship('user', 'email')
                               ->disabled(),
                         TextInput::make('email')
                                  ->email()
                                  ->required()
                                  ->maxLength(255),
                         TextInput::make('phone_prefix')
                                  ->tel()
                                  ->maxLength(10),
                         TextInput::make('phone')
                                  ->tel()
                                  ->maxLength(255),
                         TextInput::make('price')
                                  ->required(),
                         TextInput::make('promo_code')
                                  ->maxLength(255),
                         Select::make('order_type')
                               ->options([
                                             Order::TYPE_NORMAL => MenuTitles::ORDER_NORMAL,
                                             Order::TYPE_VIP    => MenuTitles::ORDER_VIP,
                                         ])
                               ->required()
                               ->label('Тариф'),
                         TextInput::make('order_number')
                                  ->required()
                                  ->maxLength(255),
                         DateTimePicker::make('order_start_booking')
                                       ->required(),
                         Select::make('order_status')
                               ->options([
                                             Order::CREATED    => MenuTitles::CREATED,
                                             Order::PAYED      => MenuTitles::PAYED,
                                             Order::PROCESSING => MenuTitles::PROCESSING,
                                             Order::CANCELED   => MenuTitles::CANCELED,
                                             Order::FINISHED   => MenuTitles::FINISHED,
                                         ])
                               ->required(),
                         TextInput::make('trip_to')
                                  ->required(),
                         TextInput::make('trip_back'),
                         TextInput::make('comment')
                                  ->maxLength(255),
                         TextInput::make('hotel_city')
                                  ->maxLength(255),
                         DateTimePicker::make('hotel_check_in'),
                         DateTimePicker::make('hotel_check_out'),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('email')
                                    ->searchable(),
                          TextColumn::make('phone_prefix'),
                          TextColumn::make('phone')
                                    ->searchable(),
                          TextColumn::make('price')
                                    ->sortable(),
                          TextColumn::make('promo_code')
                                    ->searchable(),
                          TextColumn::make('commission')
                                    ->sortable(),
                          TextColumn::make('discount')
                                    ->sortable(),
                          TextColumn::make('payment_id')
                                    ->searchable(),
                          TextColumn::make('payment_id')
                                    ->searchable(),
                          TextColumn::make('flight_to_booking_id')
                                    ->searchable(),
                          TextColumn::make('flight_from_booking_id')
                                    ->searchable(),
                          TextColumn::make('order_type')
                                    ->sortable(),
                          TextColumn::make('order_number')
                                    ->searchable(),
                          TextColumn::make('order_start_booking')
                                    ->dateTime(),
                          TextColumn::make('order_status')
                                    ->sortable(),
                          TextColumn::make('hotel_city'),

                          TextColumn::make('deleted_at')
                                    ->dateTime()
                                    ->sortable(),
                          TextColumn::make('created_at')
                                    ->dateTime()
                                    ->sortable(),
                          TextColumn::make('updated_at')
                                    ->dateTime()
                                    ->sortable(),
                      ])
            ->filters([
                          TrashedFilter::make(),
                      ])
            ->actions([
                          ViewAction::make(),
                          EditAction::make(),
                          DeleteAction::make(),
                      ])
            ->bulkActions([
                              DeleteBulkAction::make(),
                          ]);

    }

    public static function getRelations(): array
    {
        return [
            OrdersPassengerRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
