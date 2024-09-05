<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\MenuTitles;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

class OrderRelationManager extends RelationManager
{
    protected static string $relationship = 'order';

    protected static ?string $recordTitleAttribute = 'updated_at';

    public static function form(Form $form): Form
    {
        return OrderResource::form($form);
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

}
