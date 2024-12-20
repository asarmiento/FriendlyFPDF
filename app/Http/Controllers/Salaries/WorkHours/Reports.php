<?php

namespace App\Http\Controllers\Salaries\WorkHours;

use App\Http\Controllers\Controller;
use Asarmiento\FriendlyFpdf\Facades\FriendlyFpdf;

class Reports extends Controller
{
    public function generatePDF()
    {
        // Inicializar el PDF
        $pdf = FriendlyFpdf::create();
        
        // Configurar el documento
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        // Agregar título
        $pdf->Cell(190, 10, 'Reporte de Horas Trabajadas', 0, 1, 'C');
        
        // Configurar fuente para el contenido
        $pdf->SetFont('Arial', '', 12);
        
        // Agregar encabezados de tabla
        $pdf->Cell(40, 10, 'Empleado', 1);
        $pdf->Cell(40, 10, 'Fecha', 1);
        $pdf->Cell(40, 10, 'Horas', 1);
        $pdf->Cell(70, 10, 'Observaciones', 1);
        $pdf->Ln();
        
        // Aquí puedes agregar los datos de tu reporte
        // Por ejemplo:
        $workHours = [
            // Obtén tus datos aquí
        ];
        
        foreach ($workHours as $row) {
            $pdf->Cell(40, 10, $row->employee_name, 1);
            $pdf->Cell(40, 10, $row->date, 1);
            $pdf->Cell(40, 10, $row->hours, 1);
            $pdf->Cell(70, 10, $row->observations, 1);
            $pdf->Ln();
        }
        
        // Generar y descargar el PDF
        return $pdf->Output('WorkHoursReport.pdf', 'D');
    }
}