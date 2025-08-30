<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\QuoteMail;
use Illuminate\Support\Facades\Storage;

class QuoteService
{
    /**
     * Generar cotización en PDF
     */
    public function generateQuotePDF($items, $customerInfo = [])
    {
        try {
            $quoteData = [
                'items' => $items,
                'customerInfo' => $customerInfo,
                'subtotal' => $this->calculateSubtotal($items),
                'iva' => $this->calculateIVA($items),
                'total' => $this->calculateTotal($items),
                'quoteNumber' => 'COT-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'quoteDate' => now()->format('d/m/Y'),
                'validUntil' => now()->addDays(30)->format('d/m/Y'),
                'companyInfo' => [
                    'name' => 'Geoservi Spa',
                    'address' => 'Av. Industrial 1234, Rancagua, Región de O\'Higgins',
                    'phone' => '+56 9 4120 6045',
                    'email' => 'pruebasgeoservi@gmail.com',
                    'website' => 'https://geoservi.cl',
                    'rut' => '76.123.456-7'
                ]
            ];

            $pdf = PDF::loadView('pdf.quote', $quoteData);
            $pdf->setPaper('A4', 'portrait');
            
            return $pdf;

        } catch (\Exception $e) {
            Log::error('Error al generar PDF de cotización: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Guardar PDF en el servidor
     */
    public function saveQuotePDF($pdf, $quoteNumber)
    {
        try {
            $filename = 'cotizaciones/' . $quoteNumber . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());
            
            return $filename;

        } catch (\Exception $e) {
            Log::error('Error al guardar PDF: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Enviar cotización por correo
     */
    public function sendQuoteByEmail($pdf, $customerEmail, $quoteNumber, $customerInfo = [])
    {
        try {
            Mail::to($customerEmail)
                ->send(new QuoteMail($pdf, $quoteNumber, $customerInfo));

            Log::info('Cotización enviada por correo a: ' . $customerEmail);

            return true;

        } catch (\Exception $e) {
            Log::error('Error al enviar cotización por correo: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Calcular subtotal
     */
    private function calculateSubtotal($items)
    {
        return array_reduce($items, function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    }

    /**
     * Calcular IVA (19%)
     */
    private function calculateIVA($items)
    {
        $subtotal = $this->calculateSubtotal($items);
        return $subtotal * 0.19;
    }

    /**
     * Calcular total
     */
    private function calculateTotal($items)
    {
        $subtotal = $this->calculateSubtotal($items);
        $iva = $this->calculateIVA($items);
        return $subtotal + $iva;
    }

    /**
     * Obtener URL pública del PDF
     */
    public function getQuoteUrl($filename)
    {
        return Storage::disk('public')->url($filename);
    }
}
