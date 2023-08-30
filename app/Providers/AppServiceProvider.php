<?php

namespace App\Providers;

use App\Enums\EnvironmentTypeEnum;
use App\Models\PersonalAccessTokens;
use App\Services\UserDeviceService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::usePersonalAccessTokenModel(PersonalAccessTokens::class);
    }
}
