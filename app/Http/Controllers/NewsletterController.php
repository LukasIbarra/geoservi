<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsletterService;

class NewsletterController extends Controller
{
    protected $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    /**
     * Suscribir email al newsletter
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $result = $this->newsletterService->subscribeToNewsletter($request->email);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Obtener lista de suscriptores (solo para administradores)
     */
    public function index()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'No autorizado');
        }

        $subscribers = $this->newsletterService->getSubscribers();

        return view('admin.newsletter.index', compact('subscribers'));
    }

    /**
     * Eliminar suscripción
     */
    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $result = $this->newsletterService->unsubscribe($request->email);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Te has desuscrito exitosamente del newsletter.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo procesar la desuscripción.'
        ], 400);
    }
}
