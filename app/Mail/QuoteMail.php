<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $quoteNumber;
    public $customerInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, $quoteNumber, $customerInfo = [])
    {
        $this->pdf = $pdf;
        $this->quoteNumber = $quoteNumber;
        $this->customerInfo = $customerInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cotización #' . $this->quoteNumber . ' - Geoservi Spa')
                    ->view('emails.quote')
                    ->with([
                        'quoteNumber' => $this->quoteNumber,
                        'customerInfo' => $this->customerInfo,
                        'companyInfo' => [
                            'name' => 'Geoservi Spa',
                            'address' => 'Av. Industrial 1234, Rancagua, Región de O\'Higgins',
                            'phone' => '+56 9 4120 6045',
                            'email' => 'pruebasgeoservi@gmail.com'
                        ]
                    ])
                    ->attachData($this->pdf->output(), 'cotizacion-' . $this->quoteNumber . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
