<?php

namespace Bluteki\MPesa\Providers;

use Bluteki\MPesa\MPesa;
use Illuminate\Support\ServiceProvider;

class MPesaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish MPesa config file is running in console
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('mpesa.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'mpesa');

        // Register the main class to use with the facade
        $this->app->singleton('mpesa', function () {
            return new MPesa;
        });
    }
}
