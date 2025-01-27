<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
use App\Models\Restaurant;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Filament::serving(function () {
            $restaurants = Restaurant::all();

            // Общие ресурсы (Баннеры, Рестораны, Настройки)
            Filament::registerNavigationItems([
                NavigationItem::make('Баннеры')
                    ->url(route('filament.admin.resources.banners.index'))
                    ->icon('heroicon-o-photograph'),
                NavigationItem::make('Рестораны')
                    ->url(route('filament.admin.resources.restaurants.index'))
                    ->icon('heroicon-o-building-storefront'),
                NavigationItem::make('Настройки')
                    ->url(route('filament.admin.resources.settings.index'))
                    ->icon('heroicon-o-cog'),
            ]);

            // Динамическая регистрация ресторанов
            foreach ($restaurants as $restaurant) {
                // Группа для каждого ресторана
                Filament::registerNavigationItems([
                    NavigationGroup::make($restaurant->name)
                        ->items([
                            NavigationItem::make('Категории')
                                ->url(route('filament.admin.resources.categories.index', ['restaurant' => $restaurant->id]))
                                ->icon('heroicon-o-collection'),
                            NavigationItem::make('Заказы')
                                ->url(route('filament.admin.resources.orders.index', ['restaurant' => $restaurant->id]))
                                ->icon('heroicon-o-shopping-cart'),
                            NavigationItem::make('Продукты')
                                ->url(route('filament.admin.resources.products.index', ['restaurant' => $restaurant->id]))
                                ->icon('heroicon-o-cube'),
                            NavigationItem::make('Расписание')
                                ->url(route('filament.admin.resources.service-schedules.index', ['restaurant' => $restaurant->id]))
                                ->icon('heroicon-o-clock'),
                        ])
                ]);
            }
        });
    }
}