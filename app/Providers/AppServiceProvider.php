<?php

namespace App\Providers;

use App\Enums\EnvironmentTypeEnum;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

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
        //
    }
}
