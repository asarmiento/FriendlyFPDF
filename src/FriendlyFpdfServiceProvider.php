<?php

namespace Asarmiento\FriendlyFpdf;

use Illuminate\Support\ServiceProvider;
use FPDF;

class FriendlyFpdfServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge configuración
        $this->mergeConfigFrom(
            __DIR__.'/../config/friendly-fpdf.php', 'friendly-fpdf'
        );

        // Registrar Fpdf simple para inyección de dependencias
        $this->app->bind(Fpdf::class, function ($app) {
            return new Fpdf(
                $app['config']->get('friendly-fpdf.orientation', 'P'),
                $app['config']->get('friendly-fpdf.unit', 'mm'),
                $app['config']->get('friendly-fpdf.size', 'A4')
            );
        });

        // Registrar FPDF nativo como singleton
        $this->app->singleton('fpdf', function ($app) {
            return new FPDF(
                $app['config']->get('friendly-fpdf.orientation', 'P'),
                $app['config']->get('friendly-fpdf.unit', 'mm'),
                $app['config']->get('friendly-fpdf.size', 'A4')
            );
        });

        // Registrar FriendlyFpdf como singleton (mantener compatibilidad)
        $this->app->singleton('friendly-fpdf', function ($app) {
            return new FriendlyFpdf(
                $app['config']->get('friendly-fpdf.orientation', 'P'),
                $app['config']->get('friendly-fpdf.unit', 'mm'),
                $app['config']->get('friendly-fpdf.size', 'A4')
            );
        });

        // Agregar alias para facilitar el uso
        $this->app->alias('fpdf', FPDF::class);
        $this->app->alias('friendly-fpdf', FriendlyFpdf::class);
        
        // Alias adicional para compatibilidad c
        $this->app->alias(Fpdf::class, 'fpdf-simple');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/friendly-fpdf.php';

        $this->publishes([
            $configPath => config_path('friendly-fpdf.php'),
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
            'friendly-fpdf',
            FPDF::class,
            FriendlyFpdf::class
        ];
    }
} 