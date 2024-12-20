<?php

namespace Asarmiento\FriendlyFpdf;

use FPDF;

class FriendlyFpdf extends FPDF
{
    /**
     * Constructor
     */
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->setDefaultFont();
    }

    /**
     * Set default font from config
     */
    protected function setDefaultFont()
    {
        $defaultFont = config('friendly-fpdf.default_font');
        $this->SetFont(
            $defaultFont['family'],
            $defaultFont['style'],
            $defaultFont['size']
        );
    }

    /**
     * Get current orientation
     */
    public function getOrientation()
    {
        return $this->CurOrientation;
    }

    /**
     * Get current font family
     */
    public function getFontFamily()
    {
        return $this->FontFamily;
    }

    /**
     * Get current font size
     */
    public function getFontSize()
    {
        return $this->FontSizePt;
    }

    /**
     * Get current font style
     */
    public function getFontStyle()
    {
        return $this->FontStyle;
    }

    /**
     * Override Output method to support Laravel Vapor
     * 
     * @param string $dest
     * @param string $name
     * @param bool $isUTF8
     * @return string|void
     */
    public function Output($dest = '', $name = '', $isUTF8 = false)
    {
        $output = parent::Output($dest, $name, $isUTF8);

        if (config('friendly-fpdf.vapor_support') && $dest !== 'F') {
            header('Content-Transfer-Encoding: binary');
            header('Content-Type: application/pdf');
        }

        return $output;
    }

    /**
     * Create new instance
     */
    public static function create($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        return new static($orientation, $unit, $size);
    }
} 