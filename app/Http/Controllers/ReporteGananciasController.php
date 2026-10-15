<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteGananciasController extends Controller
{
    public function index(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->toDateString());
        $fechaFin = $request->get('fecha_fin', now()->toDateString());

        // Reporte por técnico (solo órdenes ENTREGADAS)
        $reporte = DB::table('ordenes_servicio')
            ->join('empleados', 'ordenes_servicio.id_empleado', '=', 'empleados.id_empleado')
            ->select(
                'empleados.id_empleado',
                'empleados.nombre_empleado',
                DB::raw('COUNT(ordenes_servicio.id_orden_servicio) as total_motos_atendidas'),
                DB::raw('SUM(ordenes_servicio.total_mano_obra) as total_mano_obra_bruto'),
                DB::raw('SUM(ordenes_servicio.ganancia_tecnico) as ganancia_tecnico_50'),
                DB::raw('SUM(ordenes_servicio.ganancia_taller) as ganancia_taller_50')
            )
            ->where('ordenes_servicio.estado_servicio', 'entregado')
            ->whereBetween('ordenes_servicio.fecha_recepcion', [$fechaInicio, $fechaFin])
            ->groupBy('empleados.id_empleado', 'empleados.nombre_empleado')
            ->get();

        $totalBruto = $reporte->sum('total_mano_obra_bruto');
        $totalTecnicos = $reporte->sum('ganancia_tecnico_50');
        $totalTaller = $reporte->sum('ganancia_taller_50');
        $totalMotos = $reporte->sum('total_motos_atendidas');

        return view('admin.ganancias', compact(
            'reporte', 'fechaInicio', 'fechaFin',
            'totalBruto', 'totalTecnicos', 'totalTaller', 'totalMotos'
        ));
    }

    /**
     * Reporte de notas impresas al cliente (día, semana o mes)
     */
    public function notasImpresas(Request $request)
    {
        $filtro = $request->get('filtro', 'dia');
        $fecha = $request->get('fecha', now()->toDateString());

        switch ($filtro) {
            case 'semana':
                $inicio = Carbon::parse($fecha)->startOfWeek()->toDateString();
                $fin = Carbon::parse($fecha)->endOfWeek()->toDateString();
                break;
            case 'mes':
                $inicio = Carbon::parse($fecha)->startOfMonth()->toDateString();
                $fin = Carbon::parse($fecha)->endOfMonth()->toDateString();
                break;
            default:
                $inicio = $fecha;
                $fin = $fecha;
                break;
        }

        $ordenes = DB::table('ordenes_servicio')
            ->join('motos', 'ordenes_servicio.id_moto', '=', 'motos.id_moto')
            ->join('clientes', 'motos.id_cliente', '=', 'clientes.id_cliente')
            ->join('empleados', 'ordenes_servicio.id_empleado', '=', 'empleados.id_empleado')
            ->select(
                'ordenes_servicio.id_orden_servicio',
                'ordenes_servicio.fecha_recepcion',
                'ordenes_servicio.estado_servicio',
                'ordenes_servicio.total_mano_obra',
                'ordenes_servicio.ganancia_taller',
                'ordenes_servicio.ganancia_tecnico',
                'motos.placa',
                'motos.marca',
                'motos.modelo',
                'clientes.nombre as nombre_cliente',
                'empleados.nombre_empleado'
            )
            ->whereBetween('ordenes_servicio.fecha_recepcion', [$inicio, $fin])
            ->orderBy('ordenes_servicio.id_orden_servicio', 'desc')
            ->get();

        $totalGeneral = $ordenes->sum('total_mano_obra');

        return view('admin.notas-impresas', compact('ordenes', 'filtro', 'fecha', 'inicio', 'fin', 'totalGeneral'));
    }

    /**
     * Reporte detallado de trabajos realizados (incluye servicios)
     */
    public function reportes(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->toDateString());
        $fechaFin = $request->get('fecha_fin', now()->toDateString());

        // Órdenes con sus datos
        $ordenes = DB::table('ordenes_servicio')
            ->join('motos', 'ordenes_servicio.id_moto', '=', 'motos.id_moto')
            ->join('clientes', 'motos.id_cliente', '=', 'clientes.id_cliente')
            ->join('empleados', 'ordenes_servicio.id_empleado', '=', 'empleados.id_empleado')
            ->select(
                'ordenes_servicio.id_orden_servicio',
                'ordenes_servicio.fecha_recepcion',
                'ordenes_servicio.estado_servicio',
                'ordenes_servicio.descripcion_falla',
                'ordenes_servicio.total_mano_obra',
                'ordenes_servicio.ganancia_taller',
                'ordenes_servicio.ganancia_tecnico',
                'motos.placa',
                'motos.marca',
                'motos.modelo',
                'clientes.nombre as nombre_cliente',
                'clientes.nit_ci',
                'empleados.nombre_empleado'
            )
            ->whereBetween('ordenes_servicio.fecha_recepcion', [$fechaInicio, $fechaFin])
            ->orderBy('ordenes_servicio.id_orden_servicio', 'desc')
            ->get();

        // Servicios de cada orden (agrupados por id_orden_servicio)
        $serviciosPorOrden = DB::table('detalle_servicios')
            ->join('servicios', 'detalle_servicios.id_servicio', '=', 'servicios.id_servicio')
            ->select(
                'detalle_servicios.id_orden_servicio',
                'servicios.nombre_servicio',
                'detalle_servicios.repuesto_traido_cliente',
                'detalle_servicios.subtotal'
            )
            ->whereIn('detalle_servicios.id_orden_servicio', $ordenes->pluck('id_orden_servicio'))
            ->get()
            ->groupBy('id_orden_servicio');

        return view('admin.reportes', compact(
            'ordenes', 'serviciosPorOrden', 'fechaInicio', 'fechaFin'
        ));
    }
}