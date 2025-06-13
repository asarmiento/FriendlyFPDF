<?php

namespace Asarmiento\FriendlyFpdf;

use FPDF;

/**
 * Clase Fpdf simple para inyección de dependencias
 * Compatible con el estilo
 */
class Fpdf extends FPDF
{
    /**
     * Constructor
     */
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->setDefaultConfig();
    }

    /**
     * Set default configuration from config
     */
    protected function setDefaultConfig()
    {
        // Solo aplicar configuración si existe
        if (function_exists('config') && config('friendly-fpdf.default_font')) {
            $defaultFont = config('friendly-fpdf.default_font');
            $this->SetFont(
                $defaultFont['family'] ?? 'Helvetica',
                $defaultFont['style'] ?? '',
                $defaultFont['size'] ?? 12
            );
        }
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
        // Soporte para Laravel Vapor
        if (function_exists('config') && config('friendly-fpdf.vapor_support') && $dest !== 'F') {
            if (!headers_sent()) {
                header('Content-Transfer-Encoding: binary');
                header('Content-Type: application/pdf');
            }
        }

        return parent::Output($dest, $name, $isUTF8);
    }
} 