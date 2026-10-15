<?php

namespace App\Http\Controllers;

use App\Models\Ordentrabajo;
use Barryvdh\DomPDF\pdf as PDF;
use Illuminate\Http\Request;

class NotaServicioController extends Controller
{
    public function generarPDF($id_orden_servicio)
    {
        $orden = Ordentrabajo::with(['moto.cliente', 'empleado', 'detalles.servicio'])->findOrFail($id_orden_servicio);

        $pdf = PDF::loadView('pdf.nota-servicio', compact('orden'));

        return $pdf->download('nota-servicio-' . str_pad($orden->id_orden_servicio, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
