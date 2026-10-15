<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReporteGananciasTecnico extends Mailable
{
    use Queueable, SerializesModels;

    public $tecnico;
    public $totalGanado;
    public $urlGanancias;

    /**
     * Constructor: recibe los datos del técnico, su ganancia total y el enlace firmado.
     */
    public function __construct($tecnico, $totalGanado, $urlGanancias)
    {
        $this->tecnico = $tecnico;
        $this->totalGanado = $totalGanado;
        $this->urlGanancias = $urlGanancias;
    }

    /**
     * Asunto del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte Diario de Ganancias - Taller El Cirujano',
        );
    }

    /**
     * Vista que se usará para el cuerpo del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte-ganancias',
        );
    }
}