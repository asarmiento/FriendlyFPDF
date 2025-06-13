<?php

namespace Asarmiento\FriendlyFpdf\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade para la clase Fpdf simple
 * Compatible con el /laravel-fpdf
 * 
 * @method static void AddPage($orientation = '', $format = '', $keepmargins = false, $tocpage = false)
 * @method static void SetFont($family, $style = '', $size = 0)
 * @method static void Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
 * @method static string Output($dest = '', $name = '', $isUTF8 = false)
 */
class Fpdf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fpdf-simple';
    }
} 