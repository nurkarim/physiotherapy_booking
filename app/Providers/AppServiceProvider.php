<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Socialite;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Socialite::extend('mollie', function ($app) {
    $config = $app['config']['services.mollie'];

    return Socialite::buildProvider('Mollie\Laravel\MollieConnectProvider', $config);
});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
