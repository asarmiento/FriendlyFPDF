<?php

/**
 * Ejemplos de uso de FriendlyFpdf
 * 
 * Este archivo demuestra las diferentes formas de usar la librería:
 * 1. Inyección de dependencias (/laravel-fpdf)
 * 2. Interfaz fluida (estilo original FriendlyFpdf)
 * 3. Facades
 */

// =============================================================================
// 1. INYECCIÓN DE DEPENDENCIAS (/laravel-fpdf)
// =============================================================================

use Asarmiento\FriendlyFpdf\Fpdf;

// En routes/web.php
Route::get('pdf-simple', function (Fpdf $fpdf) {
    $fpdf->AddPage();
    $fpdf->SetFont('Arial', 'B', 16);
    $fpdf->Cell(0, 10, '¡Hola Mundo con Inyección!', 0, 1, 'C');
    $fpdf->Output('I', 'simple.pdf');
});

// En un Controller
class PdfController extends Controller
{
    public function reporteMensual(Fpdf $fpdf)
    {
        $fpdf->AddPage();
        
        // Título
        $fpdf->SetFont('Arial', 'B', 18);
        $fpdf->Cell(0, 15, 'Reporte Mensual', 0, 1, 'C');
        
        // Línea de separación
        $fpdf->Ln(5);
        $fpdf->Line(10, $fpdf->GetY(), 200, $fpdf->GetY());
        $fpdf->Ln(10);
        
        // Contenido
        $fpdf->SetFont('Arial', '', 12);
        $fpdf->Cell(0, 8, 'Fecha: ' . date('Y-m-d'), 0, 1);
        $fpdf->Cell(0, 8, 'Usuario: ' . auth()->user()->name ?? 'Invitado', 0, 1);
        
        $fpdf->Ln(5);
        
        // Tabla de datos
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(50, 10, 'Producto', 1, 0, 'C');
        $fpdf->Cell(40, 10, 'Cantidad', 1, 0, 'C');
        $fpdf->Cell(40, 10, 'Precio', 1, 1, 'C');
        
        $fpdf->SetFont('Arial', '', 11);
        $productos = [
            ['Producto A', 10, '$100.00'],
            ['Producto B', 5, '$50.00'],
            ['Producto C', 15, '$150.00']
        ];
        
        foreach ($productos as $producto) {
            $fpdf->Cell(50, 8, $producto[0], 1, 0);
            $fpdf->Cell(40, 8, $producto[1], 1, 0, 'C');
            $fpdf->Cell(40, 8, $producto[2], 1, 1, 'R');
        }
        
        return response($fpdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reporte-mensual.pdf"'
        ]);
    }
    
    public function factura(Request $request, Fpdf $fpdf)
    {
        $fpdf->AddPage();
        
        // Encabezado de la factura
        $fpdf->SetFont('Arial', 'B', 20);
        $fpdf->Cell(0, 15, 'FACTURA', 0, 1, 'C');
        
        $fpdf->SetFont('Arial', '', 12);
        $fpdf->Cell(0, 8, 'No. Factura: ' . $request->get('numero', '001'), 0, 1);
        $fpdf->Cell(0, 8, 'Fecha: ' . date('Y-m-d'), 0, 1);
        
        // Datos del cliente
        $fpdf->Ln(10);
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(0, 8, 'DATOS DEL CLIENTE:', 0, 1);
        $fpdf->SetFont('Arial', '', 11);
        $fpdf->Cell(0, 6, 'Nombre: ' . $request->get('cliente', 'Cliente Ejemplo'), 0, 1);
        $fpdf->Cell(0, 6, 'Dirección: ' . $request->get('direccion', 'Dirección Ejemplo'), 0, 1);
        
        // Detalles de la factura
        $fpdf->Ln(10);
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(80, 10, 'Descripción', 1, 0, 'C');
        $fpdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
        $fpdf->Cell(30, 10, 'Precio', 1, 0, 'C');
        $fpdf->Cell(30, 10, 'Total', 1, 1, 'C');
        
        $fpdf->SetFont('Arial', '', 11);
        $items = $request->get('items', [
            ['Producto Ejemplo', 2, 50.00, 100.00]
        ]);
        
        $subtotal = 0;
        foreach ($items as $item) {
            $fpdf->Cell(80, 8, $item[0], 1, 0);
            $fpdf->Cell(30, 8, $item[1], 1, 0, 'C');
            $fpdf->Cell(30, 8, '$' . number_format($item[2], 2), 1, 0, 'R');
            $fpdf->Cell(30, 8, '$' . number_format($item[3], 2), 1, 1, 'R');
            $subtotal += $item[3];
        }
        
        // Totales
        $fpdf->Ln(5);
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(140, 8, 'Subtotal:', 0, 0, 'R');
        $fpdf->Cell(30, 8, '$' . number_format($subtotal, 2), 1, 1, 'R');
        
        $iva = $subtotal * 0.16;
        $fpdf->Cell(140, 8, 'IVA (16%):', 0, 0, 'R');
        $fpdf->Cell(30, 8, '$' . number_format($iva, 2), 1, 1, 'R');
        
        $total = $subtotal + $iva;
        $fpdf->Cell(140, 8, 'Total:', 0, 0, 'R');
        $fpdf->Cell(30, 8, '$' . number_format($total, 2), 1, 1, 'R');
        
        return response($fpdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="factura.pdf"'
        ]);
    }
}

// =============================================================================
// 2. INTERFAZ FLUIDA (Estilo original FriendlyFpdf)
// =============================================================================

use Asarmiento\FriendlyFpdf\Facades\FriendlyFpdf;

class ReportesController extends Controller
{
    public function reporteVentas()
    {
        return FriendlyFpdf::addPage()
            ->addText('Reporte de Ventas', 105, 20, 'C')
            ->addText('Período: ' . date('Y-m'), 20, 40)
            ->addText('Total Ventas: $5,000.00', 20, 50)
            ->addText('Total Productos: 150', 20, 60)
            ->Output('D', 'reporte-ventas.pdf');
    }
    
    public function certificado($nombre)
    {
        return FriendlyFpdf::addPage('L') // Horizontal
            ->addText('CERTIFICADO DE PARTICIPACIÓN', 148, 40, 'C')
            ->addText('Se certifica que', 148, 70, 'C')
            ->addText(strtoupper($nombre), 148, 90, 'C')
            ->addText('Ha participado exitosamente en el curso', 148, 110, 'C')
            ->addText('Fecha: ' . date('d/m/Y'), 148, 140, 'C')
            ->Output('I', 'certificado-' . $nombre . '.pdf');
    }
}

// =============================================================================
// 3. FACADES SIMPLES
// =============================================================================

use Asarmiento\FriendlyFpdf\Facades\Fpdf;

class DocumentosController extends Controller
{
    public function contrato()
    {
        Fpdf::AddPage();
        Fpdf::SetFont('Arial', 'B', 16);
        Fpdf::Cell(0, 15, 'CONTRATO DE SERVICIOS', 0, 1, 'C');
        
        Fpdf::SetFont('Arial', '', 12);
        Fpdf::Ln(10);
        
        $texto = "Este contrato establece los términos y condiciones para la prestación de servicios...";
        Fpdf::MultiCell(0, 8, $texto);
        
        Fpdf::Ln(20);
        
        // Firmas
        Fpdf::Cell(85, 8, 'Firma del Cliente:', 0, 0);
        Fpdf::Cell(85, 8, 'Firma del Proveedor:', 0, 1);
        
        Fpdf::Ln(20);
        
        Fpdf::Cell(85, 8, '_____________________', 0, 0);
        Fpdf::Cell(85, 8, '_____________________', 0, 1);
        
        return Fpdf::Output('I', 'contrato.pdf');
    }
    
    public function recibo($monto, $concepto)
    {
        Fpdf::AddPage();
        Fpdf::SetFont('Arial', 'B', 18);
        Fpdf::Cell(0, 15, 'RECIBO DE PAGO', 0, 1, 'C');
        
        Fpdf::SetFont('Arial', '', 12);
        Fpdf::Ln(10);
        
        Fpdf::Cell(0, 8, 'Fecha: ' . date('d/m/Y'), 0, 1);
        Fpdf::Cell(0, 8, 'Monto: $' . number_format($monto, 2), 0, 1);
        Fpdf::Cell(0, 8, 'Concepto: ' . $concepto, 0, 1);
        
        Fpdf::Ln(20);
        Fpdf::Cell(0, 8, 'Recibido por: _____________________', 0, 1);
        
        return Fpdf::Output('D', 'recibo.pdf');
    }
}

// =============================================================================
// 4. EJEMPLOS AVANZADOS
// =============================================================================

class ReportesAvanzadosController extends Controller
{
    public function reporteConGraficos(Fpdf $fpdf)
    {
        $fpdf->AddPage();
        
        // Título
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 15, 'Reporte con Gráficos', 0, 1, 'C');
        
        // Gráfico de barras simple
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(0, 10, 'Ventas por Mes:', 0, 1);
        
        $fpdf->SetFont('Arial', '', 10);
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May'];
        $ventas = [1000, 1500, 1200, 1800, 2000];
        
        $x = 20;
        $y = 50;
        
        foreach ($meses as $i => $mes) {
            $altura = $ventas[$i] / 50; // Escala
            $fpdf->Rect($x, $y + 50 - $altura, 20, $altura, 'F');
            $fpdf->Text($x + 5, $y + 65, $mes);
            $fpdf->Text($x + 2, $y + 45 - $altura, '$' . $ventas[$i]);
            $x += 30;
        }
        
        return response($fpdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf'
        ]);
    }
    
    public function reporteMultiPagina(Fpdf $fpdf)
    {
        $fpdf->AddPage();
        
        // Encabezado personalizado
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 15, 'Reporte Extenso - Página 1', 0, 1, 'C');
        
        // Contenido de la primera página
        $fpdf->SetFont('Arial', '', 12);
        for ($i = 1; $i <= 30; $i++) {
            $fpdf->Cell(0, 8, "Línea $i de contenido en la primera página", 0, 1);
        }
        
        // Segunda página
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 15, 'Reporte Extenso - Página 2', 0, 1, 'C');
        
        $fpdf->SetFont('Arial', '', 12);
        for ($i = 31; $i <= 60; $i++) {
            $fpdf->Cell(0, 8, "Línea $i de contenido en la segunda página", 0, 1);
        }
        
        return response($fpdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reporte-multipagina.pdf"'
        ]);
    }
} 