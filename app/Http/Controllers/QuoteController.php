<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuoteService;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Generar PDF de cotización
     */
    public function generatePDF(Request $request)
    {
        try {
            // Decodificar items si vienen como JSON string
            $items = $request->items;
            if (is_string($items)) {
                $items = json_decode($items, true);
            }

            $request->merge(['items' => $items]);

            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer|min:1',
                'customer_email' => 'nullable|email',
                'customer_name' => 'nullable|string',
                'customer_phone' => 'nullable|string',
                'customer_company' => 'nullable|string',
                'customer_address' => 'nullable|string'
            ]);

            $customerInfo = [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
                'company' => $request->customer_company,
                'address' => $request->customer_address
            ];

            // Filtrar información del cliente vacía
            $customerInfo = array_filter($customerInfo);

            // Generar PDF
            $pdf = $this->quoteService->generateQuotePDF($items, $customerInfo);
            
            // Si se proporcionó email, enviar por correo
            if (!empty($request->customer_email)) {
                $quoteNumber = 'COT-' . date('Ymd') . '-' . strtoupper(uniqid());
                $this->quoteService->sendQuoteByEmail($pdf, $request->customer_email, $quoteNumber, $customerInfo);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cotización generada y enviada por correo exitosamente',
                    'quote_number' => $quoteNumber
                ]);
            }

            // Devolver PDF para descarga
            return $pdf->download('cotizacion-' . date('Ymd-His') . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error al generar cotización: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar la cotización: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Solo generar PDF (sin enviar por correo)
     */
    public function downloadPDF(Request $request)
    {
        try {
            // Decodificar items si vienen como JSON string
            $items = $request->items;
            if (is_string($items)) {
                $items = json_decode($items, true);
            }

            $request->merge(['items' => $items]);

            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer|min:1'
            ]);

            $pdf = $this->quoteService->generateQuotePDF($items);
            
            return $pdf->download('cotizacion-' . date('Ymd-His') . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error al descargar cotización: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar la cotización para descarga: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Solo enviar por correo (PDF ya generado)
     */
    public function sendEmail(Request $request)
    {
        try {
            // Decodificar items si vienen como JSON string
            $items = $request->items;
            if (is_string($items)) {
                $items = json_decode($items, true);
            }

            $request->merge(['items' => $items]);

            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer|min:1',
                'customer_email' => 'required|email',
                'customer_name' => 'nullable|string',
                'customer_phone' => 'nullable|string',
                'customer_company' => 'nullable|string'
            ]);

            $customerInfo = [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
                'company' => $request->customer_company
            ];

            // Filtrar información del cliente vacía
            $customerInfo = array_filter($customerInfo);

            // Generar PDF
            $pdf = $this->quoteService->generateQuotePDF($items, $customerInfo);
            $quoteNumber = 'COT-' . date('Ymd') . '-' . strtoupper(uniqid());
            
            // Enviar por correo
            $this->quoteService->sendQuoteByEmail($pdf, $request->customer_email, $quoteNumber, $customerInfo);

            return response()->json([
                'success' => true,
                'message' => 'Cotización enviada por correo exitosamente',
                'quote_number' => $quoteNumber
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar cotización por correo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar la cotización por correo: ' . $e->getMessage()
            ], 500);
        }
    }
}
