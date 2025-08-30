<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\NewsletterSubscription;
use Illuminate\Support\Facades\DB;

class NewsletterService
{
    /**
     * Suscribir un email al newsletter
     */
    public function subscribeToNewsletter($email)
    {
        try {
            // Verificar si el email ya está suscrito
            $existing = DB::table('newsletter_subscriptions')
                ->where('email', $email)
                ->first();

            if ($existing) {
                return [
                    'success' => false,
                    'message' => 'Este email ya está suscrito a nuestro newsletter.'
                ];
            }

            // Insertar en la base de datos
            DB::table('newsletter_subscriptions')->insert([
                'email' => $email,
                'subscribed_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Enviar email de confirmación
            Mail::to($email)->send(new NewsletterSubscription());

            Log::info('Nueva suscripción al newsletter: ' . $email);

            return [
                'success' => true,
                'message' => '¡Te has suscrito exitosamente a nuestro newsletter!'
            ];

        } catch (\Exception $e) {
            Log::error('Error al suscribir al newsletter: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Ocurrió un error al procesar tu suscripción. Por favor, inténtalo de nuevo.'
            ];
        }
    }

    /**
     * Obtener todos los suscriptores
     */
    public function getSubscribers()
    {
        return DB::table('newsletter_subscriptions')
            ->orderBy('subscribed_at', 'desc')
            ->get();
    }

    /**
     * Eliminar suscripción
     */
    public function unsubscribe($email)
    {
        try {
            $deleted = DB::table('newsletter_subscriptions')
                ->where('email', $email)
                ->delete();

            if ($deleted) {
                Log::info('Email eliminado del newsletter: ' . $email);
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Error al eliminar suscripción: ' . $e->getMessage());
            return false;
        }
    }
}
