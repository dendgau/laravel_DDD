<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Utils\CustomDateTime;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CustomDateTime::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
