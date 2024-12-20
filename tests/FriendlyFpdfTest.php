<?php

namespace Asarmiento\FriendlyFpdf\Tests;

use Asarmiento\FriendlyFpdf\FriendlyFpdf;
use FPDF;

class FriendlyFpdfTest extends TestCase
{
    /** @test */
    public function it_can_create_instance()
    {
        $pdf = new FriendlyFpdf();
        $this->assertInstanceOf(FriendlyFpdf::class, $pdf);
        $this->assertInstanceOf(FPDF::class, $pdf);
    }

    /** @test */
    public function it_can_create_instance_using_static_method()
    {
        $pdf = FriendlyFpdf::create();
        $this->assertInstanceOf(FriendlyFpdf::class, $pdf);
    }

    /** @test */
    public function it_uses_default_font_from_config()
    {
        $pdf = new FriendlyFpdf();
        
        $this->assertEquals('helvetica', $pdf->getFontFamily());
        $this->assertEquals(12, $pdf->getFontSize());
    }

    /** @test */
    public function it_can_create_pdf_with_custom_orientation()
    {
        $pdf = new FriendlyFpdf('L');
        $this->assertEquals('L', $pdf->getOrientation());
    }

    /** @test */
    public function it_supports_vapor_headers()
    {
        $this->markTestSkipped('Este test requiere modificación del header');
    }

    /** @test */
    public function it_can_add_page()
    {
        $pdf = new FriendlyFpdf();
        $pdf->AddPage();
        
        $this->assertEquals(1, $pdf->PageNo());
    }

    /** @test */
    public function it_can_set_font()
    {
        $pdf = new FriendlyFpdf();
        $pdf->SetFont('Arial', 'B', 16);
        
        $this->assertEquals('helvetica', $pdf->getFontFamily());
        $this->assertEquals(16, $pdf->getFontSize());
        $this->assertEquals('B', $pdf->getFontStyle());
    }
} 