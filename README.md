# FriendlyFpdf para Laravel

Una librería amigable para generar PDFs en Laravel usando FPDF. Esta librería proporciona **dos formas de uso**:

1. **Interfaz fluida** (FriendlyFpdf): Métodos encadenables para facilitar el uso
2. **Inyección de dependencias** (Fpdf): Compatible con el estilo 

## Características

- **Dos formas de uso**: Interfaz fluida y inyección de dependencias
- Configuración personalizable
- Integración sencilla con Laravel
- Basado en la librería FPDF
- Soporte para Laravel 8.x, 9.x y 10.x
- Compatible con Laravel Vapor
- Inyección de dependencias en rutas y controladores

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

Ahora puedes usar la librería de **dos formas diferentes**:

### Forma 1: Inyección de Dependencias (/laravel-fpdf)

```php
// En routes/web.php
use Asarmiento\FriendlyFpdf\Fpdf;

Route::get('pdf', function (Fpdf $fpdf) {
    $fpdf->AddPage();
    $fpdf->SetFont('Arial', 'B', 16);
    $fpdf->Cell(0, 10, '¡Hola Mundo!', 0, 1, 'C');
    $fpdf->Output('I', 'documento.pdf');
});

// En un Controller
class PdfController extends Controller
{
    public function generate(Fpdf $fpdf)
    {
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 10, '¡Hola Mundo!', 0, 1, 'C');
        return response($fpdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="documento.pdf"'
        ]);
    }
}
```

### Forma 2: Interfaz Fluida (FriendlyFpdf - Original)

```php
use Asarmiento\FriendlyFpdf\Facades\FriendlyFpdf;

public function generatePdf()
{
    return FriendlyFpdf::addPage()
        ->addText('¡Hola Mundo!', 10, 10)
        ->Output('I', 'documento.pdf');
}
```

### Forma 3: Facade Simple 

```php
use Asarmiento\FriendlyFpdf\Facades\Fpdf;

public function generatePdf()
{
    Fpdf::AddPage();
    Fpdf::SetFont('Arial', 'B', 16);
    Fpdf::Cell(0, 10, '¡Hola Mundo!', 0, 1, 'C');
    return Fpdf::Output('I', 'documento.pdf');
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

### Ejemplo con Inyección de Dependencias ()

```php
use Asarmiento\FriendlyFpdf\Fpdf;

// En routes/web.php
Route::get('reporte', function (Fpdf $fpdf) {
    $fpdf->AddPage();
    $fpdf->SetFont('Arial', 'B', 18);
    $fpdf->Cell(0, 15, 'Reporte Mensual', 0, 1, 'C');
    
    $fpdf->SetFont('Arial', '', 12);
    $fpdf->Cell(0, 10, 'Fecha: ' . date('Y-m-d'), 0, 1);
    $fpdf->Cell(0, 10, 'Este es un ejemplo de reporte', 0, 1);
    
    $fpdf->Output('D', 'reporte.pdf');
});

// En un Controller con respuesta personalizada
class ReporteController extends Controller
{
    public function generar(Fpdf $fpdf)
    {
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 18);
        $fpdf->Cell(0, 15, 'Reporte Avanzado', 0, 1, 'C');
        
        // Agregar contenido dinámico
        $data = collect(['Item 1', 'Item 2', 'Item 3']);
        $fpdf->SetFont('Arial', '', 12);
        
        foreach ($data as $item) {
            $fpdf->Cell(0, 8, $item, 0, 1);
        }
        
        return response($fpdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reporte.pdf"'
        ]);
    }
}
```

### Ejemplo con Interfaz Fluida (Original)

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
// Con inyección de dependencias
Route::get('save-pdf', function (Fpdf $fpdf) {
    $fpdf->AddPage();
    $fpdf->SetFont('Arial', '', 12);
    $fpdf->Cell(0, 10, 'Contenido guardado', 0, 1);
    $fpdf->Output('F', storage_path('app/pdfs/documento.pdf'));
    
    return 'PDF guardado exitosamente';
});

// Con interfaz fluida
FriendlyFpdf::addPage()
    ->addText('Contenido del PDF', 10, 10)
    ->Output('F', storage_path('app/pdfs/documento.pdf'));
```



2. **El código existente funcionará sin cambios:**
   ```php
   // Esto seguirá funcionando exactamente igual
   Route::get('/', function (xxxxxxx\Fpdf\Fpdf $fpdf) {
       $fpdf->AddPage();
       $fpdf->SetFont('Courier', 'B', 18);
       $fpdf->Cell(50, 25, 'Hello World!');
       $fpdf->Output();
   });
   
   // Solo cambia el namespace:
   Route::get('/', function (Asarmiento\FriendlyFpdf\Fpdf $fpdf) {
       $fpdf->AddPage();
       $fpdf->SetFont('Courier', 'B', 18);
       $fpdf->Cell(50, 25, 'Hello World!');
       $fpdf->Output();
   });
   ```

3. **Configuración compatible:**
   - Mantén la variable de entorno `FPDF_VAPOR_HEADERS=true` para Laravel Vapor
   - La configuración de fuentes es compatible
   - Todas las características de FPDF están disponibles

### Ventajas adicionales

Al usar `asarmiento/friendly-fpdf` obtienes:

- ✅ **Interfaz fluida adicional** para desarrollo más rápido
- ✅ **Mejor configuración** con más opciones predeterminadas
- ✅ **Facades adicionales** para mayor flexibilidad
- ✅ **Documentación en español**

## Ejemplos Completos

Para ver ejemplos detallados de todas las formas de uso, consulta el archivo [`examples/usage_examples.php`](examples/usage_examples.php) que incluye:

- 📋 **Reportes con tablas**
- 🧾 **Facturas completas**
- 📜 **Certificados**
- 📊 **Gráficos simples**
- 📄 **Documentos multipágina**
- 🔗 **Integración con controladores**

## Documentación Adicional

### Variables de Entorno

```bash
# Para Laravel Vapor
FPDF_VAPOR_HEADERS=true
```

### Configuración Avanzada

```php
// config/friendly-fpdf.php
return [
    'orientation' => 'P',           // P = Portrait, L = Landscape
    'unit' => 'mm',                // mm, pt, cm, in
    'size' => 'A4',                // A4, A5, Letter, Legal, etc.
    
    'default_font' => [
        'family' => 'Helvetica',    // Arial, Helvetica, Times, Courier
        'style'  => '',             // '', 'B', 'I', 'U'
        'size'   => 12
    ],
    
    'vapor_support' => env('FPDF_VAPOR_HEADERS', false),
];
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