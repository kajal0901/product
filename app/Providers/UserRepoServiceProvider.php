<?php

namespace App\Providers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\CartInterface;
use App\Repositories\Auth\CartRepository;
use App\Repositories\Auth\OrderInterface;
use App\Repositories\Auth\OrderRepository;
use App\Repositories\Auth\ProductInterface;
use App\Repositories\Auth\ProductRepository;
use App\Repositories\Auth\UserInterface;
use Illuminate\Support\ServiceProvider;

class UserRepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CartInterface::class,
            CartRepository::class
        );

        $this->app->bind(
            OrderInterface::class,
            OrderRepository::class
        );
    }
}
