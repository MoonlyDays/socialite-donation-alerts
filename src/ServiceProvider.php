<?php

namespace MoonlyDays\LaravelDonationAlerts;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void {
        $this->publishes([
            __DIR__."/../config/donationalerts.php" => config_path('donationalerts.php'),
        ]);
    }

    public function register(): void {
        $this->mergeConfigFrom(
            __DIR__.'/../config/donationalerts.php', 'donationalerts'
        );

        $this->app->singleton(DonationAlerts::class, function ($app) {
            return new DonationAlerts(config("donationalerts"));
        });
    }

}