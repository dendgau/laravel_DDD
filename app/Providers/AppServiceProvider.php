<?php

namespace App\Providers;

use Hkonnet\LaravelEbay\EbayServices;
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
            \Domain\Services\Api\Ebay\InventoryService::class,
            true
        );

        $this->app->singleton('EbayPostOrder', function ($app) {
            return $app->make(EbayServices::class)->createPostOrder(config('ebays.header'));
        });

        $this->app->singleton('EbayInventory', function ($app) {
            return $app->make(EbayServices::class)->createInventory(config('ebays.header'));
        });

        $this->app->singleton('EbayOAuth', function ($app) {
            $config = array_merge(config('ebays.header'), [
                'ruName' => config('ebays.RuName')
            ]);
            return $app->make(EbayServices::class)->createOAuth($config);
        });
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
