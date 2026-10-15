<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GananciasDiariasNotification;

class EnviarReporteGanancias extends Command
{
    // Nombre del comando en Artisan
    protected $signature = 'reporte:ganancias-tecnicos';
    protected $description = 'Envía un enlace firmado por correo a cada técnico con sus ganancias al cierre de jornada';

    public function handle()
    {
        // 1. Obtener técnicos activos con correo registrado
        $tecnicos = DB::table('empleados')
            ->where('cargo', 'tecnico')
            ->where('estado', 'activo')
            ->whereNotNull('email_empleado')
            ->get();

        if ($tecnicos->isEmpty()) {
            $this->info('No se encontraron técnicos activos con correo electrónico.');
            return 0;
        }

        foreach ($tecnicos as $tecnico) {
            // 2. Calcular las ganancias acumuladas (estado entregado)
            $ordenes = DB::table('ordenes_servicio')
                ->where('id_empleado', $tecnico->id_empleado)
                ->where('estado_servicio', 'entregado')
                ->get();

            $totalGanado = $ordenes->sum('ganancia_tecnico');

            // 3. Generar la ruta firmada temporal (Expira en 24 horas)
            $urlFirmada = URL::temporarySignedRoute(
                'tecnico.ganancias',
                now()->addDay(),
                ['id' => $tecnico->id_empleado]
            );

            // 4. Simular un objeto "Notifiable" para enviar el correo directamente a su dirección
            Notification::route('mail', $tecnico->email_empleado)
                ->notify(new GananciasDiariasNotification($tecnico, $urlFirmada, $totalGanado));

            $this->info("Correo enviado con éxito a: {$tecnico->email_empleado}");
        }

        $this->info('Proceso de envío de reportes diario finalizado.');
        return 0;
    }
}