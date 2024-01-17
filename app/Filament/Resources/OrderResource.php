<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Http\Controllers\PaymentController;
use App\Models\Order;
use App\Services\TinkoffPaymentService;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->disabled(),
                Forms\Components\TextInput::make('price')
                    ->regex('/^[0-9]+$/')
                    ->required(),
                Select::make('order_status')
                    ->options([
                        Order::CREATED => __('admin-panel.order_status.created'),
                        Order::PAYED => __('admin-panel.order_status.payed'),
                        Order::EXPIRED => __('admin-panel.order_status.expired'),
                        Order::PROCESSING => __('admin-panel.order_status.processing'),
                        Order::CANCELED => __('admin-panel.order_status.canceled'),
                        Order::FINISHED => __('admin-panel.order_status.finished'),
                    ])
                    ->required(),
                Select::make('order_type')
                    ->options([
                        Order::NORMAL => __('admin-panel.order_type.normal'),
                        Order::VIP => __('admin-panel.order_type.vip'),
                        Order::PREMIUM => __('admin-panel.order_type.premium'),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->label('период (д)')
                    ->regex('/^[0-9]+$/')
                    ->required(),
                Forms\Components\TextInput::make('payment_id')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.email')
                    ->searchable()
                    ->toggledHiddenByDefault(false),
                TextColumn::make('price')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('order_status')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('order_type')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('duration')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('payment_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('rebill_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('cancel')
                        ->action(function (Order $record) {
                            (new TinkoffPaymentService())->cancelPayment($record);
                            $record->order_status=Order::CANCELED;
                            $record->save();
                        })
                        ->label('Возврат')
                        ->color('danger')
                        ->icon('heroicon-o-x')
                        ->requiresConfirmation(),
                    Action::make('charge')
                        ->action(function (Order $record) {
                            (new PaymentController(new TinkoffPaymentService()))->charge($record->id);
                        })

                        ->label('Продлить')
                        ->color('success')
                        ->icon('heroicon-o-currency-dollar')
                        ->requiresConfirmation(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('admin-panel.order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin-panel.orders');
    }

    public static function canCreate(): bool
    {
        return false;
    }


}
