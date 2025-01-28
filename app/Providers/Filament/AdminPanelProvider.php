<?php

namespace App\Providers\Filament;

use App\Models\Restaurant;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $restaurants = Restaurant::all();

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#BE1522',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigation(function (NavigationBuilder $builder) use ($restaurants): NavigationBuilder {
                $builder->groups([
                    NavigationGroup::make('Общие ресурсы')
                        ->items([
                            NavigationItem::make('Баннеры')
                                ->url(route('filament.admin.resources.banners.index'))
                                ->icon('heroicon-o-photo'),
                            NavigationItem::make('Рестораны')
                                ->url(route('filament.admin.resources.restaurants.index'))
                                ->icon('heroicon-o-building-storefront'),
                            NavigationItem::make('Настройки')
                                ->url(route('filament.admin.resources.settings.index'))
                                ->icon('heroicon-o-cog'),
                        ]),
                ]);

                foreach ($restaurants as $restaurant) {
                    $builder->group(
                        NavigationGroup::make($restaurant->name)
                            ->items([
                                NavigationItem::make('Категории')
                                    ->url(route('filament.admin.resources.categories.index', ['restaurant' => $restaurant->id]))
                                    ->icon('heroicon-o-rectangle-stack'),
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
                    );
                }

                return $builder;
            });
    }
}
