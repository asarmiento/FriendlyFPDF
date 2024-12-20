<?php

namespace Asarmiento\FriendlyFpdf;

use fpdf\FPDF;

class FriendlyFpdf extends FPDF
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        parent::__construct(
            $this->config['orientation'],
            $this->config['unit'],
            $this->config['format']
        );
        
        $this->SetMargins(
            $this->config['margin_left'],
            $this->config['margin_top'],
            $this->config['margin_right']
        );
        
        $this->SetFont($this->config['default_font'], '', $this->config['default_size']);
    }

    public function addPage($orientation = '', $size = '', $rotation = 0)
    {
        parent::AddPage($orientation, $size, $rotation);
        return $this;
    }

    public function addText($text, $x = null, $y = null, $align = 'L')
    {
        if ($x !== null && $y !== null) {
            $this->SetXY($x, $y);
        }
        $this->Cell(0, 10, $text, 0, 1, $align);
        return $this;
    }
} 