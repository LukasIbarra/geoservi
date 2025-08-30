<?php

namespace App\Services;

use App\Models\Maquinaria;
use App\Models\User;
use App\Models\NotificacionEnvio;
use App\Models\NotificacionRegla;
use App\Models\NotificacionConfiguracion;
use App\Mail\MantenimientoCriticoMail;
use App\Mail\MantenimientoPreventivoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotificacionService
{
    /**
     * Verificar horómetros y enviar notificaciones según reglas
     */
    public function verificarHorometrosYNotificar()
    {
        $maquinarias = Maquinaria::with(['pautas'])
            ->where('estado', 'activo')
            ->get();

        foreach ($maquinarias as $maquinaria) {
            $this->evaluarMaquinaria($maquinaria);
        }
    }

    /**
     * Evaluar una máquina específica y enviar notificaciones si corresponde
     */
    public function evaluarMaquinaria(Maquinaria $maquinaria)
    {
        foreach ($maquinaria->pautas as $pauta) {
            $ultimaMantencion = $pauta->pivot->ultima_mantencion_horas ?? 0;
            $proximaMantencion = $ultimaMantencion + $pauta->frecuencia_horas;
            $horasRestantes = $proximaMantencion - $maquinaria->horometro_actual;
            
            // Determinar tipo de notificación basado en horas restantes
            $tipoNotificacion = $this->determinarTipoNotificacion($horasRestantes);
            
            if ($tipoNotificacion) {
                $this->procesarNotificacion($maquinaria, $pauta, $horasRestantes, $tipoNotificacion);
            }
        }
    }

    /**
     * Determinar el tipo de notificación según las horas restantes
     */
    private function determinarTipoNotificacion($horasRestantes)
    {
        if ($horasRestantes <= 0) {
            return 'critica';
        } elseif ($horasRestantes <= 24) {
            return 'critica';
        } elseif ($horasRestantes <= 50) {
            return 'preventiva';
        } elseif ($horasRestantes <= 100) {
            return 'preventiva';
        }
        
        return null;
    }

    /**
     * Procesar y enviar notificación
     */
    private function procesarNotificacion($maquinaria, $pauta, $horasRestantes, $tipoNotificacion)
    {
        // Verificar si ya se envió una notificación reciente
        if ($this->yaNotificadoRecientemente($maquinaria->id, $tipoNotificacion)) {
            return;
        }

        // Obtener destinatarios según el tipo
        $destinatarios = $this->obtenerDestinatarios($tipoNotificacion);
        
        // Determinar canales según criticidad
        $canales = $this->determinarCanales($tipoNotificacion);
        
        foreach ($destinatarios as $usuario) {
            foreach ($canales as $canal) {
                $this->enviarNotificacion(
                    $usuario,
                    $maquinaria,
                    $pauta,
                    $horasRestantes,
                    $tipoNotificacion,
                    $canal
                );
            }
        }
    }

    /**
     * Verificar si ya se notificó recientemente
     */
    private function yaNotificadoRecientemente($maquinariaId, $tipo)
    {
        $horasMinimas = [
            'critica' => 2,
            'preventiva' => 24,
            'informativa' => 168 // 1 semana
        ];
        
        $ultimaNotificacion = NotificacionEnvio::where('maquinaria_id', $maquinariaId)
            ->where('tipo', $tipo)
            ->where('estado', 'enviado')
            ->where('created_at', '>=', Carbon::now()->subHours($horasMinimas[$tipo]))
            ->first();
            
        return $ultimaNotificacion !== null;
    }

    /**
     * Obtener usuarios destinatarios según tipo de notificación
     */
    private function obtenerDestinatarios($tipoNotificacion)
    {
        $roles = [
            'critica' => ['tecnico', 'supervisor', 'jefe'],
            'preventiva' => ['tecnico', 'supervisor'],
            'informativa' => ['supervisor', 'jefe']
        ];
        
        return User::where('notificaciones_activas', true)
            ->whereIn('rol_notificacion', $roles[$tipoNotificacion])
            ->get();
    }

    /**
     * Determinar canales de envío según tipo
     */
    private function determinarCanales($tipoNotificacion)
    {
        $canalesConfig = [
            'critica' => ['email', 'sms', 'whatsapp'],
            'preventiva' => ['email', 'whatsapp'],
            'informativa' => ['email']
        ];
        
        return $canalesConfig[$tipoNotificacion];
    }

    /**
     * Enviar notificación por canal específico
     */
    private function enviarNotificacion($usuario, $maquinaria, $pauta, $horasRestantes, $tipo, $canal)
    {
        // Verificar configuración del usuario para este canal
        $config = NotificacionConfiguracion::where('usuario_id', $usuario->id)
            ->where('canal', $canal)
            ->where('activo', true)
            ->first();
            
        if (!$config) {
            return;
        }
        
        // Verificar horario permitido
        if (!$this->enHorarioPermitido($config)) {
            return;
        }
        
        // Preparar mensaje
        $mensaje = $this->prepararMensaje($maquinaria, $pauta, $horasRestantes, $tipo, $canal);
        
        // Crear registro de envío
        $envio = NotificacionEnvio::create([
            'maquinaria_id' => $maquinaria->id,
            'usuario_id' => $usuario->id,
            'tipo' => $tipo,
            'canal' => $canal,
            'mensaje' => $mensaje,
            'estado' => 'pendiente',
            'metadata' => [
                'pauta_id' => $pauta->id,
                'horas_restantes' => $horasRestantes,
                'horometro_actual' => $maquinaria->horometro_actual
            ]
        ]);
        
        // Enviar según canal
        try {
            switch ($canal) {
                case 'email':
                    $this->enviarEmail($usuario, $maquinaria, $pauta, $horasRestantes, $tipo);
                    break;
                case 'sms':
                    $this->enviarSMS($config->direccion, $mensaje);
                    break;
                case 'whatsapp':
                    $this->enviarWhatsApp($config->direccion, $mensaje);
                    break;
            }
            
            $envio->update([
                'estado' => 'enviado',
                'fecha_envio' => now()
            ]);
            
        } catch (\Exception $e) {
            $envio->update([
                'estado' => 'fallido',
                'intentos' => $envio->intentos + 1
            ]);
            
            Log::error("Error enviando notificación: " . $e->getMessage());
        }
    }

    /**
     * Verificar si estamos en horario permitido
     */
    private function enHorarioPermitido($config)
    {
        $ahora = Carbon::now();
        $horaActual = $ahora->format('H:i');
        $diaActual = $ahora->format('N'); // 1=Lunes, 7=Domingo
        
        // Mapeo de días
        $diasMap = [
            1 => 'L', 2 => 'M', 3 => 'X', 4 => 'J', 
            5 => 'V', 6 => 'S', 7 => 'D'
        ];
        
        // Verificar día
        if (!str_contains($config->dias_semana, $diasMap[$diaActual])) {
            return false;
        }
        
        // Verificar hora
        return $horaActual >= $config->horario_inicio && $horaActual <= $config->horario_fin;
    }

    /**
     * Preparar mensaje según canal y tipo
     */
    private function prepararMensaje($maquinaria, $pauta, $horasRestantes, $tipo, $canal)
    {
        $estado = $horasRestantes <= 0 ? 'VENCIDO' : "{$horasRestantes} hrs restantes";
        
        switch ($canal) {
            case 'sms':
                return $this->mensajeSMS($maquinaria, $estado, $tipo);
            case 'whatsapp':
                return $this->mensajeWhatsApp($maquinaria, $pauta, $horasRestantes, $tipo);
            default:
                return $this->mensajeEmail($maquinaria, $pauta, $horasRestantes, $tipo);
        }
    }

    /**
     * Mensaje para SMS (corto)
     */
    private function mensajeSMS($maquinaria, $estado, $tipo)
    {
        $emoji = $tipo === 'critica' ? '🔴' : '🟡';
        return "{$emoji} {$maquinaria->nombre}: {$estado}. Horómetro: {$maquinaria->horometro_actual}hrs. Acción requerida.";
    }

    /**
     * Mensaje para WhatsApp
     */
    private function mensajeWhatsApp($maquinaria, $pauta, $horasRestantes, $tipo)
    {
        $emoji = $tipo === 'critica' ? '🚨' : '⚠️';
        $urgencia = $tipo === 'critica' ? '*URGENTE*' : 'PREVENTIVO';
        
        $mensaje = "{$emoji} *ALERTA DE MANTENIMIENTO {$urgencia}*\n\n";
        $mensaje .= "*Máquina:* {$maquinaria->nombre}\n";
        $mensaje .= "*Tipo:* {$maquinaria->tipo}\n";
        $mensaje .= "*Horómetro Actual:* " . number_format($maquinaria->horometro_actual) . " hrs\n";
        
        if ($horasRestantes <= 0) {
            $mensaje .= "*Estado:* 🔴 VENCIDO (" . abs($horasRestantes) . " hrs excedidas)\n";
        } else {
            $mensaje .= "*Horas Restantes:* {$horasRestantes} hrs\n";
        }
        
        $mensaje .= "*Pauta Requerida:* {$pauta->nombre}\n";
        $mensaje .= "*Frecuencia:* Cada {$pauta->frecuencia_horas} hrs\n\n";
        
        if ($tipo === 'critica') {
            $mensaje .= "⚠️ *ACCIÓN REQUERIDA INMEDIATA*\n";
            $mensaje .= "1. Programar mantención urgente\n";
            $mensaje .= "2. Notificar al supervisor\n";
            $mensaje .= "3. Confirmar recepción respondiendo OK\n";
        }
        
        $mensaje .= "\n📱 Ver detalles: " . url("/admin/maquinarias/{$maquinaria->id}");
        
        return $mensaje;
    }

    /**
     * Mensaje para Email
     */
    private function mensajeEmail($maquinaria, $pauta, $horasRestantes, $tipo)
    {
        // Este será el contenido HTML del email
        return view('emails.notificacion-mantenimiento', compact(
            'maquinaria', 'pauta', 'horasRestantes', 'tipo'
        ))->render();
    }

    /**
     * Enviar Email
     */
    private function enviarEmail($usuario, $maquinaria, $pauta, $horasRestantes, $tipo)
    {
        $mailClass = $tipo === 'critica' 
            ? MantenimientoCriticoMail::class 
            : MantenimientoPreventivoMail::class;
            
        Mail::to($usuario->email)->send(
            new $mailClass($maquinaria, $pauta, $horasRestantes)
        );
    }

    /**
     * Enviar SMS (placeholder - requiere Twilio)
     */
    private function enviarSMS($telefono, $mensaje)
    {
        // TODO: Implementar con Twilio
        Log::info("SMS a {$telefono}: {$mensaje}");
        
        // Cuando se implemente Twilio:
        // $twilio = new \Twilio\Rest\Client(
        //     config('services.twilio.sid'),
        //     config('services.twilio.token')
        // );
        // 
        // $twilio->messages->create(
        //     $telefono,
        //     [
        //         'from' => config('services.twilio.phone'),
        //         'body' => $mensaje
        //     ]
        // );
    }

    /**
     * Enviar WhatsApp (placeholder - requiere Twilio WhatsApp)
     */
    private function enviarWhatsApp($numero, $mensaje)
    {
        // TODO: Implementar con Twilio WhatsApp Business
        Log::info("WhatsApp a {$numero}: {$mensaje}");
        
        // Cuando se implemente:
        // $twilio = new \Twilio\Rest\Client(
        //     config('services.twilio.sid'),
        //     config('services.twilio.token')
        // );
        // 
        // $twilio->messages->create(
        //     "whatsapp:{$numero}",
        //     [
        //         'from' => "whatsapp:" . config('services.twilio.whatsapp'),
        //         'body' => $mensaje
        //     ]
        // );
    }

    /**
     * Enviar resumen diario a supervisores
     */
    public function enviarResumenDiario()
    {
        $supervisores = User::where('rol_notificacion', 'supervisor')
            ->where('notificaciones_activas', true)
            ->get();
            
        $resumen = $this->generarResumenDiario();
        
        foreach ($supervisores as $supervisor) {
            Mail::to($supervisor->email)->send(
                new \App\Mail\ResumenDiarioMail($resumen)
            );
        }
    }

    /**
     * Generar datos para resumen diario
     */
    private function generarResumenDiario()
    {
        return [
            'maquinas_criticas' => Maquinaria::whereHas('pautas', function($q) {
                // Lógica para máquinas críticas
            })->count(),
            'mantenciones_hoy' => OrdenTrabajo::whereDate('created_at', today())->count(),
            'notificaciones_enviadas' => NotificacionEnvio::whereDate('created_at', today())->count(),
            // Más estadísticas...
        ];
    }
}
