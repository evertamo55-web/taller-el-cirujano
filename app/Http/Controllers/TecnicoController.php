<?php

namespace App\Http\Controllers;

use App\Mail\NotificarFinJornada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class TecnicoController extends Controller
{
    /**
     * Dashboard móvil del técnico.
     * Muestra los trabajos asignados y la comisión acumulada del 50%.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Órdenes asignadas a este técnico (todas menos las ya entregadas)
        $ordenesPendientes = DB::table('ordenes_servicio')
            ->join('motos', 'ordenes_servicio.id_moto', '=', 'motos.id_moto')
            ->join('clientes', 'motos.id_cliente', '=', 'clientes.id_cliente')
            ->select(
                'ordenes_servicio.id_orden_servicio',
                'ordenes_servicio.fecha_recepcion',
                'ordenes_servicio.descripcion_falla',
                'ordenes_servicio.estado_servicio',
                'ordenes_servicio.total_mano_obra',
                'motos.placa',
                'motos.marca',
                'motos.modelo',
                'clientes.nombre as nombre_cliente'
            )
            ->where('ordenes_servicio.id_empleado', $user->id_empleado)
            ->whereIn('ordenes_servicio.estado_servicio', ['pendiente', 'en_progreso', 'completado'])
            ->orderBy('ordenes_servicio.fecha_recepcion', 'desc')
            ->get();

        // Total de mano de obra acumulada (solo entregadas hoy o en el período)
        $totalManoObra = DB::table('ordenes_servicio')
            ->where('id_empleado', $user->id_empleado)
            ->where('estado_servicio', 'entregado')
            ->sum('total_mano_obra');

        // Cálculo del 50% para el técnico
        $comisionTecnico = $totalManoObra * 0.50;

        // Cantidad de motos atendidas
        $motosAtendidas = DB::table('ordenes_servicio')
            ->where('id_empleado', $user->id_empleado)
            ->where('estado_servicio', 'entregado')
            ->count();

        return view('tecnico.dashboard', compact(
            'ordenesPendientes',
            'totalManoObra',
            'comisionTecnico',
            'motosAtendidas'
        ));
    }

    /**
     * Finaliza la jornada laboral de un técnico y envía un correo
     * con un enlace firmado para que consulte sus ganancias.
     * Accesible solo para el rol propietario (administrador).
     */
    public function finalizarJornada($id_empleado)
    {
        $tecnico = \App\Models\Empleado::findOrFail($id_empleado);

        // Verificar que el técnico tenga un correo registrado
        if (empty($tecnico->email_empleado)) {
            return redirect()->back()
                ->with('error', "El técnico {$tecnico->nombre_empleado} no tiene un correo electrónico registrado.");
        }

        // Calcular ganancia del técnico (50% de mano de obra entregada)
        $totalManoObra = DB::table('ordenes_servicio')
            ->where('id_empleado', $id_empleado)
            ->where('estado_servicio', 'entregado')
            ->sum('total_mano_obra');

        $totalGanado = $totalManoObra * 0.50;

        // Generar URL firmada válida por 24 horas
        $urlGanancias = URL::temporarySignedRoute(
            'tecnico.ganancias',
            now()->addHours(24),
            ['id' => $id_empleado]
        );

        // Enviar correo notificando fin de jornada
        Mail::to($tecnico->email_empleado)->send(new NotificarFinJornada($tecnico, $totalGanado, $urlGanancias));

        return redirect()->back()
            ->with('success', "Se envió un correo a {$tecnico->nombre_empleado} ({$tecnico->email_empleado}) con el enlace a sus ganancias.");
    }
}