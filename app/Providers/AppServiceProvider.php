<?php

namespace App\Providers;

use App\Enums\EnvironmentTypeEnum;
use App\Models\PersonalAccessTokens;
use Filament\Facades\Filament;
use Filament\Forms\Components\Field;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Filament\Forms\Components\Actions\Action;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (App::environment(EnvironmentTypeEnum::notProductEnv())) {
            $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Field::macro("tooltip", function (string $tooltip) {
            return $this->hintAction(
                Action::make('help')
                      ->icon('heroicon-o-question-mark-circle')
                      ->tooltip($tooltip)
            );
        });

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerNavigationGroups([
                                                   NavigationGroup::make()
                                                                  ->label(__('admin-panel.app'),)
                                                                  ->icon('heroicon-o-sparkles'),
                                                   NavigationGroup::make()
                                                                  ->label(__('admin-panel.settings'))
                                                                  ->icon('heroicon-o-cog')
                                                                  ->collapsed(),
                                               ]);
        });
        Sanctum::usePersonalAccessTokenModel(PersonalAccessTokens::class);
    }
}
