<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Enviar correo
            Mail::to('pruebasgeoservi@gmail.com')->send(new ContactoMail($request->all()));
            
            // Log de éxito
            Log::info('Correo de contacto enviado exitosamente desde: ' . $request->email);
            
            return response()->json([
                'success' => true,
                'message' => 'Consulta enviada con éxito. Nos pondremos en contacto contigo pronto.'
            ], 200);
            
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al enviar tu consulta. Por favor, inténtalo de nuevo o contáctanos directamente por teléfono.'
            ], 500);
        }
    }
}
