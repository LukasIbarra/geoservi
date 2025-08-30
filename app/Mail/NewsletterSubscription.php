<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Bienvenido/a al Newsletter de Geoservi!')
                    ->view('emails.newsletter')
                    ->with([
                        'company' => 'Geoservi Spa',
                        'slogan' => 'Soluciones integrales en equipos mineros y servicios industriales'
                    ]);
    }
}
