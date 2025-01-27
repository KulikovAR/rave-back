<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getNavigationLabel(): string
    {
        return 'Заказы';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Заказы';
    }

    public static function getModelLabel(): string
    {
        return 'Заказ';
    }

    public static function form(Form $form): Form
    {
        $restaurantId = request('restaurant');
        // dd($restaurantId);

        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_phone')
                    ->label('Телефон заказчика')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->label('Статус заказа')
                    ->options([
                        'new' => 'Новый',
                        'processing' => 'В процессе',
                        'completed' => 'Завершён',
                        'canceled' => 'Отменён',
                    ])
                    ->default('new')
                    ->required(),

                Forms\Components\Repeater::make('orderProducts')
                    ->relationship('orderProducts')
                    ->reactive()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Продукт')
                            ->options(function (callable $get) use ($restaurantId) {
                                // Переопределяем загрузку продуктов для каждого нового элемента
                                return Product::whereHas('category', function ($query) use ($restaurantId) {
                                    $query->where('restaurant_id', $restaurantId);
                                })->pluck('name', 'id')->toArray();
                            })
                            ->required()
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                self::handleProductChange($state, $set, $get);
                                $set("orderProducts.{$key}.product_id", $state);
                            }),

                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->reactive()
                            ->disabled()
                            ->required(),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Количество')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->reactive()
                            ->minValue(1)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                self::handleQuantityChange($state, $set, $get);
                            }),

                        Forms\Components\TextInput::make('total_item_price')
                            ->label('Цена за позицию')
                            ->numeric()
                            ->disabled()
                            ->required(),
                    ])
                    ->columns(3)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        self::recalculateTotalPrice($set, $get);
                    })
                    ->afterStateHydrated(function ($state, callable $set, callable $get) {
                        self::hydrateOrderProducts($state, $set, $get);
                    }),

                Forms\Components\TextInput::make('total_price')
                    ->label('Общая стоимость')
                    ->numeric()
                    ->disabled()
                    ->reactive()
                    ->default(0),
            ]);
    }

    public static function handleProductChange($state, callable $set, callable $get): void
    {
        $product = Product::find($state);
        if ($product) {
            $set('price', $product->price);
            $set('total_item_price', $product->price * (float) $get('quantity'));
        }
        self::recalculateTotalPrice($set, $get);
    }

    public static function handleQuantityChange($state, callable $set, callable $get): void
    {
        $set('total_item_price', (float) $get('price') * $state);
        self::recalculateTotalPrice($set, $get);
    }

    public static function hydrateOrderProducts($state, callable $set, callable $get): void
    {
        foreach ($state as $key => $orderProduct) {
            if (! empty($orderProduct['product_id'])) {
                $product = Product::find($orderProduct['product_id']);
                if ($product) {
                    $set("orderProducts.{$key}.price", $product->price);
                    $set("orderProducts.{$key}.total_item_price", $product->price * $orderProduct['quantity']);
                }
            }
        }
        self::recalculateTotalPrice($set, $get);
    }

    public static function recalculateTotalPrice(callable $set, callable $get): void
    {
        $orderProducts = $get('orderProducts');

        if (! $orderProducts) {
            $set('total_price', 0);

            return;
        }

        foreach ($orderProducts as $key => $orderProduct) {
            if (! isset($orderProduct['price'])) {
                $orderProducts[$key]['price'] = Product::find($orderProduct['product_id'])?->price;
            }
        }

        $totalPrice = collect($orderProducts)->sum(function ($product) {
            return (float) ($product['price'] ?? 0) * (float) ($product['quantity'] ?? 0);
        });

        $set('total_price', $totalPrice);
    }

    public static function table(Table $table): Table
    {
        $restaurantId = request('restaurant');

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('customer_phone')->label('Телефон заказчика'),
                Tables\Columns\TextColumn::make('total_price')->label('Итоговая стоимость'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус')
                    ->getStateUsing(function ($record) {
                        $statuses = [
                            'new' => 'Новый',
                            'processing' => 'В процессе',
                            'completed' => 'Завершён',
                            'canceled' => 'Отменён',
                        ];

                        return $statuses[$record->status] ?? $record->status;
                    })
                    ->colors([
                        'primary' => 'Новый',
                        'warning' => 'В процессе',
                        'success' => 'Завершён',
                        'danger' => 'Отменён',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('Дата создания'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.orders.edit', [
                        'record' => $record->id,
                        'restaurant' => $restaurantId,  // Прокидываем restaurant_id
                    ])),
            ])
            ->query(function () use ($restaurantId) {
                return Order::query()
                    ->whereHas('products.category', function ($query) use ($restaurantId) {
                        $query->where('restaurant_id', $restaurantId);
                    });
            })
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit/{restaurant}'),
        ];
    }
}