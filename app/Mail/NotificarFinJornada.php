<?php

namespace App\Mail;

use App\Models\Empleado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificarFinJornada extends Mailable
{
    use Queueable, SerializesModels;

    public Empleado $tecnico;
    public float $totalGanado;
    public string $urlGanancias;

    public function __construct(Empleado $tecnico, float $totalGanado, string $urlGanancias)
    {
        $this->tecnico = $tecnico;
        $this->totalGanado = $totalGanado;
        $this->urlGanancias = $urlGanancias;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Taller El Cirujano - Fin de Jornada Laboral',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte-ganancias',
            with: [
                'tecnico' => $this->tecnico,
                'totalGanado' => $this->totalGanado,
                'urlGanancias' => $this->urlGanancias,
            ],
        );
    }
}
