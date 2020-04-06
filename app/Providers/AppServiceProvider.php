<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind Repository via interface
        $this->app->bind(
            \Domain\Contracts\Repositories\UserRepositoryContract::class,
            \Domain\Repositories\UserRepository::class,
            true
        );

        // Bind Service via interface
        $this->app->bind(
            \Domain\Contracts\Services\TestingServiceContract::class,
            \Domain\Services\TestingService::class,
            true
        );
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
