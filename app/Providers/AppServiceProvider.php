<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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

        $this->app->bind(
            \Domain\Contracts\Repositories\BlogRepositoryContract::class,
            \Domain\Repositories\BlogRepository::class,
            true
        );

        $this->app->bind(
            \Domain\Contracts\Repositories\CommentRepositoryContract::class,
            \Domain\Repositories\CommentRepository::class,
            true
        );

        // Bind Service via interface
        $this->app->bind(
            \Domain\Contracts\Services\TestingServiceContract::class,
            \Domain\Services\TestingService::class,
            true
        );

        $this->app->bind(
            \Domain\Contracts\Services\BlogServiceContract::class,
            \Domain\Services\BlogService::class,
            true
        );

        $this->app->bind(
            \Domain\Contracts\Services\CommentServiceContract::class,
            \Domain\Services\CommentService::class,
            true
        );

        $this->app->bind(
            \Domain\Contracts\Services\EbayServiceContract::class,
            \Domain\Services\Api\EbayService::class,
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
        // To fix length of email when migrate DB
        Schema::defaultStringLength(191);
    }
}
