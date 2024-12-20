# FriendlyFpdf para Laravel

Una librería amigable para generar PDFs en Laravel usando FPDF. Esta librería proporciona una interfaz fluida y fácil de usar para crear documentos PDF en aplicaciones Laravel.

## Características

- Interfaz fluida para generar PDFs
- Configuración personalizable
- Integración sencilla con Laravel
- Basado en la librería FPDF
- Soporte para Laravel 8.x, 9.x y 10.x

## Requisitos

- PHP 7.4 o superior
- Laravel 8.x, 9.x o 10.x

## Instalación

Puedes instalar el paquete vía composer:

```bash
composer require asarmiento/friendly-fpdf
```

## Configuración

1. El Service Provider se registra automáticamente en Laravel 8+.

2. Publica el archivo de configuración:

```bash
php artisan vendor:publish --provider="Asarmiento\FriendlyFpdf\FriendlyFpdfServiceProvider"
```

3. Esto creará un archivo `config/friendly-fpdf.php` con las siguientes opciones:

```php
return [
    'default_font' => 'Arial',     // Fuente predeterminada
    'default_size' => 12,          // Tamaño de fuente predeterminado
    'margin_left' => 10,           // Margen izquierdo en mm
    'margin_right' => 10,          // Margen derecho en mm
    'margin_top' => 10,            // Margen superior en mm
    'margin_bottom' => 10,         // Margen inferior en mm
    'orientation' => 'P',          // Orientación: P (Portrait) o L (Landscape)
    'unit' => 'mm',               // Unidad de medida (mm, pt, cm, in)
    'format' => 'A4'              // Formato del papel
];
```

## Uso Básico

### Crear un PDF Simple

```php
use Asarmiento\FriendlyFpdf\Facades\FriendlyFpdf;

public function generatePdf()
{
    return FriendlyFpdf::addPage()
        ->addText('¡Hola Mundo!', 10, 10)
        ->Output('I', 'documento.pdf');
}
```

### Métodos Disponibles

#### Gestión de Páginas
```php
// Añadir una nueva página
FriendlyFpdf::addPage($orientation = '', $size = '', $rotation = 0);
```

#### Texto
```php
// Añadir texto en una posición específica
FriendlyFpdf::addText($text, $x = null, $y = null, $align = 'L');

// Los valores válidos para $align son:
// 'L' - Alineación izquierda
// 'C' - Centrado
// 'R' - Alineación derecha
```

#### Salida del PDF
```php
// Generar el PDF
FriendlyFpdf::Output($destination = 'I', $filename = 'doc.pdf');

// Valores para $destination:
// 'I' - Enviar al navegador
// 'D' - Forzar descarga
// 'F' - Guardar en archivo local
// 'S' - Retornar como string
```

## Ejemplos de Uso

### Crear un Documento con Múltiples Elementos

```php
use Asarmiento\FriendlyFpdf\Facades\FriendlyFpdf;

public function generateReport()
{
    return FriendlyFpdf::addPage()
        ->addText('Reporte Mensual', 10, 10, 'C')
        ->addText('Fecha: ' . date('Y-m-d'), 10, 20)
        ->addText('Este es un ejemplo de reporte', 10, 30)
        ->Output('D', 'reporte.pdf');
}
```

### Guardar PDF en Archivo

```php
FriendlyFpdf::addPage()
    ->addText('Contenido del PDF', 10, 10)
    ->Output('F', storage_path('app/pdfs/documento.pdf'));
```

## Contribuir

Las contribuciones son bienvenidas y serán completamente creditadas.

1. Fork el repositorio
2. Crea tu rama de características (`git checkout -b feature/amazing-feature`)
3. Commit tus cambios (`git commit -m 'Add some amazing feature'`)
4. Push a la rama (`git push origin feature/amazing-feature`)
5. Abre un Pull Request

## Seguridad

Si descubres algún problema de seguridad, por favor envía un email a info@friendlysystemgroup.com en lugar de usar el issue tracker.

## Créditos

- [Anwar Sarmiento](https://github.com/asarmiento)
- [Todos los Contribuyentes](../../contributors)

## Licencia

The MIT License (MIT). Por favor, consulta el [archivo de licencia](LICENSE.md) para más información.