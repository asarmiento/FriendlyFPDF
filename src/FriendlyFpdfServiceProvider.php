<?php

namespace Asarmiento\FriendlyFpdf;

use Illuminate\Support\ServiceProvider;
use FPDF;

class FriendlyFpdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/friendly-fpdf.php', 'friendly-fpdf'
        );

        $this->app->singleton('fpdf', function () {
            return new FPDF();
        });

        $this->app->singleton('friendly-fpdf', function ($app) {
            return new FriendlyFpdf($app['config']['friendly-fpdf']);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/friendly-fpdf.php' => config_path('friendly-fpdf.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'fpdf',
            'friendly-fpdf'
        ];
    }
} 