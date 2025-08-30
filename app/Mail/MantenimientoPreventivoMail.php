<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Maquinaria;
use App\Models\Pauta;

class MantenimientoPreventivoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maquinaria;
    public $pauta;
    public $horasRestantes;

    /**
     * Create a new message instance.
     */
    public function __construct(Maquinaria $maquinaria, Pauta $pauta, $horasRestantes)
    {
        $this->maquinaria = $maquinaria;
        $this->pauta = $pauta;
        $this->horasRestantes = $horasRestantes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⚠️ Mantenimiento Preventivo: {$this->maquinaria->nombre} - {$this->horasRestantes} horas restantes",
            tags: ['mantenimiento', 'preventivo'],
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
            view: 'emails.mantenimiento-preventivo',
            with: [
                'maquinaria' => $this->maquinaria,
                'pauta' => $this->pauta,
                'horasRestantes' => $this->horasRestantes,
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
