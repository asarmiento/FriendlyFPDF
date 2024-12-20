<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default configuration for FPDF
    |--------------------------------------------------------------------------
    |
    | Specify the default values for creating a PDF with FPDF
    |
    */

    'orientation' => 'P',
    'unit' => 'mm',
    'size' => 'A4',

    /*
    |--------------------------------------------------------------------------
    | Default font settings
    |--------------------------------------------------------------------------
    |
    | Default font settings for the PDF document
    |
    */
    'default_font' => [
        'family' => 'Helvetica',
        'style'  => '',
        'size'   => 12
    ],

    /*
    |--------------------------------------------------------------------------
    | Vapor Support
    |--------------------------------------------------------------------------
    |
    | If you're using Laravel Vapor, set this to true to add the necessary
    | headers for proper PDF display
    |
    */
    'vapor_support' => env('FPDF_VAPOR_HEADERS', false),
]; 