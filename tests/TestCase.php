<?php

namespace Asarmiento\FriendlyFpdf\Tests;

use Asarmiento\FriendlyFpdf\FriendlyFpdfServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FriendlyFpdfServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Configuración de prueba
        $app['config']->set('friendly-fpdf.orientation', 'P');
        $app['config']->set('friendly-fpdf.unit', 'mm');
        $app['config']->set('friendly-fpdf.size', 'A4');
    }
} 