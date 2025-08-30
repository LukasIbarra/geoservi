<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Maquinaria;
use App\Models\Pauta;

class MantenimientoCriticoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maquinaria;
    public $pauta;
    public $horasRestantes;
    public $estadoCritico;
    public $accionRequerida;

    /**
     * Create a new message instance.
     */
    public function __construct(Maquinaria $maquinaria, Pauta $pauta, $horasRestantes)
    {
        $this->maquinaria = $maquinaria;
        $this->pauta = $pauta;
        $this->horasRestantes = $horasRestantes;
        
        // Determinar estado crítico
        if ($horasRestantes <= 0) {
            $this->estadoCritico = 'VENCIDO';
            $this->accionRequerida = 'DETENER OPERACIÓN INMEDIATAMENTE';
        } elseif ($horasRestantes <= 24) {
            $this->estadoCritico = 'MUY CRÍTICO';
            $this->accionRequerida = 'Programar mantención en las próximas 24 horas';
        } else {
            $this->estadoCritico = 'CRÍTICO';
            $this->accionRequerida = 'Programar mantención urgente';
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $asunto = "🔴 ALERTA CRÍTICA: {$this->maquinaria->nombre} - Mantención ";
        $asunto .= $this->horasRestantes <= 0 ? 'VENCIDA' : 'URGENTE';
        
        return new Envelope(
            subject: $asunto,
            tags: ['mantenimiento', 'critico', 'urgente'],
            metadata: [
                'maquinaria_id' => $this->maquinaria->id,
                'pauta_id' => $this->pauta->id,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mantenimiento-critico',
            with: [
                'maquinaria' => $this->maquinaria,
                'pauta' => $this->pauta,
                'horasRestantes' => $this->horasRestantes,
                'estadoCritico' => $this->estadoCritico,
                'accionRequerida' => $this->accionRequerida,
                'urlAccion' => url("/admin/ordenes/crear?maquinaria={$this->maquinaria->id}&pauta={$this->pauta->id}"),
                'urlMaquinaria' => url("/admin/maquinarias/{$this->maquinaria->id}"),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
