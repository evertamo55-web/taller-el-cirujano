<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReporteGananciasTecnico;


// Enviar correos todos los días a las 19:00
Schedule::call(function () {
    $tecnicos = DB::table('empleados')
        ->where('cargo', 'tecnico')
        ->where('estado', 'activo')
        ->whereNotNull('email_empleado')
        ->get();

    foreach ($tecnicos as $tecnico) {
        $totalGanado = DB::table('ordenes_servicio')
            ->where('id_empleado', $tecnico->id_empleado)
            ->where('estado_servicio', 'entregado')
            ->whereDate('fecha_recepcion', today())
            ->sum('ganancia_tecnico');

        if ($totalGanado > 0) {
            $url = \URL::temporarySignedRoute(
                'tecnico.ganancias',
                now()->endOfDay(), // Caduca al final del día
                ['id' => $tecnico->id_empleado]
            );

            Mail::to($tecnico->email_empleado)
                ->send(new ReporteGananciasTecnico($tecnico, $totalGanado, $url));
        }
    }
})->dailyAt('19:00');
Schedule::command('reporte:ganancias-tecnicos')->dailyAt('20:00');