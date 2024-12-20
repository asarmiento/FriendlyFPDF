<?php

namespace Asarmiento\FriendlyFpdf\Tests;

use Asarmiento\FriendlyFpdf\FriendlyFpdf;
use FPDF;

class FriendlyFpdfServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_fpdf_singleton()
    {
        $fpdf = app('fpdf');
        $this->assertInstanceOf(FPDF::class, $fpdf);
    }

    /** @test */
    public function it_registers_friendly_fpdf_singleton()
    {
        $pdf = app('friendly-fpdf');
        $this->assertInstanceOf(FriendlyFpdf::class, $pdf);
    }

    /** @test */
    public function it_registers_config_file()
    {
        $this->assertArrayHasKey('friendly-fpdf', config()->all());
    }

    /** @test */
    public function it_uses_config_values_for_initialization()
    {
        config([
            'friendly-fpdf.orientation' => 'L',
            'friendly-fpdf.unit' => 'pt',
            'friendly-fpdf.size' => 'Letter'
        ]);

        $pdf = app('friendly-fpdf');
        
        $this->assertEquals('L', $pdf->getOrientation());
    }

    /** @test */
    public function it_provides_correct_services()
    {
        $provider = app()->getProvider(\Asarmiento\FriendlyFpdf\FriendlyFpdfServiceProvider::class);
        $provided = $provider->provides();

        $this->assertContains('fpdf', $provided);
        $this->assertContains('friendly-fpdf', $provided);
        $this->assertContains(FPDF::class, $provided);
        $this->assertContains(FriendlyFpdf::class, $provided);
    }
} 