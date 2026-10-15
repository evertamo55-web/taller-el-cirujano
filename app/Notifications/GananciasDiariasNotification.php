<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GananciasDiariasNotification extends Notification
{
    use Queueable;

    protected $tecnico;
    protected $urlFirmada;
    protected $totalGanado;

    public function __construct($tecnico, $urlFirmada, $totalGanado)
    {
        $this->tecnico = $tecnico;
        $this->urlFirmada = $urlFirmada;
        $this->totalGanado = $totalGanado;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reporte Diario de Ganancias - Taller El Cirujano')
            ->greeting('¡Hola, ' . $this->tecnico->nombre_empleado . '!')
            ->line('La jornada del día de hoy ha finalizado en el taller.')
            ->line('Tu ganancia acumulada para hoy es de: *Bs. ' . number_format($this->totalGanado, 2) . '*')
            ->action('Ver Detalle de Mis Ganancias', $this->urlFirmada)
            ->line('Este enlace es de uso personal y expirará automáticamente al finalizar el día de mañana por seguridad.')
            ->salutation('Atentamente, Taller El Cirujano.');
    }
}