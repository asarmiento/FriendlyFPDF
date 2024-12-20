<?php

namespace Asarmiento\FriendlyFpdf\Facades;

use Illuminate\Support\Facades\Facade;

class FriendlyFpdf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'friendly-fpdf';
    }
} 