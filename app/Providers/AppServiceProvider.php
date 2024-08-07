<?php

namespace App\Providers;

use App\Utils\CurrencyService;
use App\Utils\OrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind('currency.facade', function () {
            return new CurrencyService();
        });

        $this->app->bind('order.facade', function () {
            return new OrderService();
        });
    }
}
