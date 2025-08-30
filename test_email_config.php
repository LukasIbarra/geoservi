<?php
/**
 * Script de prueba de configuración de email
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "🧪 PROBANDO CONFIGURACIÓN DE EMAIL\n";
echo "========================================\n\n";

// Obtener configuración
$mailConfig = config('mail');
echo "📧 Configuración actual:\n";
echo "   Host: " . $mailConfig['mailers']['smtp']['host'] . "\n";
echo "   Puerto: " . $mailConfig['mailers']['smtp']['port'] . "\n";
echo "   Usuario: " . $mailConfig['mailers']['smtp']['username'] . "\n";
echo "   Desde: " . $mailConfig['from']['address'] . "\n\n";

// Intentar enviar email de prueba
try {
    echo "📤 Enviando email de prueba...\n";
    
    Mail::raw('🎉 ¡Configuración exitosa!

Este es un email de prueba del Sistema de Notificaciones de Geoservi.

Si recibes este mensaje, significa que la configuración de email está funcionando correctamente.

Información del sistema:
- Fecha/Hora: ' . date('Y-m-d H:i:s') . '
- Servidor: Laravel ' . app()->version() . '
- Ambiente: ' . app()->environment() . '

Próximos pasos:
1. Las notificaciones automáticas están listas para funcionar
2. El sistema verificará los horómetros cada hora
3. Se enviarán alertas según los umbrales configurados

--
Sistema de Mantenimiento Geoservi
Notificaciones Automáticas', function($message) {
        $message->to('pruebasgeoservi@gmail.com')
                ->subject('✅ Prueba de Configuración - Sistema de Notificaciones Geoservi');
    });
    
    echo "✅ Email enviado exitosamente!\n";
    echo "   Revisa la bandeja de entrada de pruebasgeoservi@gmail.com\n\n";
    
    // Probar plantilla HTML
    echo "📤 Enviando email con plantilla HTML...\n";
    
    // Simular datos de máquina
    $maquinaria = new stdClass();
    $maquinaria->id = 1;
    $maquinaria->nombre = 'Excavadora CAT 320D';
    $maquinaria->tipo = 'Excavadora';
    $maquinaria->marca = 'Caterpillar';
    $maquinaria->modelo = '320D';
    $maquinaria->serie = 'CAT320D2024001';
    $maquinaria->horometro_actual = 4980;
    
    $pauta = new stdClass();
    $pauta->id = 1;
    $pauta->nombre = 'Mantenimiento 5000 horas';
    $pauta->frecuencia_horas = 5000;
    
    $horasRestantes = 20;
    
    // Determinar estado crítico
    $estadoCritico = $horasRestantes <= 0 ? 'VENCIDO' : 'CRÍTICO';
    $accionRequerida = $horasRestantes <= 0 
        ? 'DETENER OPERACIÓN INMEDIATAMENTE - Mantenimiento vencido'
        : 'Programar mantenimiento urgente en las próximas ' . $horasRestantes . ' horas';
    
    // Enviar con plantilla
    Mail::send('emails.mantenimiento-critico', [
        'maquinaria' => $maquinaria,
        'pauta' => $pauta,
        'horasRestantes' => $horasRestantes,
        'estadoCritico' => $estadoCritico,
        'accionRequerida' => $accionRequerida,
        'urlAccion' => url('/admin/ordenes/crear'),
        'urlMaquinaria' => url('/admin/maquinarias/1'),
    ], function($message) {
        $message->to('pruebasgeoservi@gmail.com')
                ->subject('🚨 ALERTA CRÍTICA - Mantenimiento Requerido');
    });
    
    echo "✅ Email HTML enviado exitosamente!\n\n";
    
    echo "🎉 CONFIGURACIÓN COMPLETADA CON ÉXITO\n";
    echo "========================================\n";
    echo "El sistema está listo para enviar notificaciones automáticas.\n\n";
    
} catch (Exception $e) {
    echo "❌ ERROR al enviar email:\n";
    echo "   " . $e->getMessage() . "\n\n";
    
    echo "🔧 SOLUCIONES POSIBLES:\n";
    echo "1. Verifica que la contraseña de aplicación esté correcta en .env\n";
    echo "2. Asegúrate de tener conexión a internet\n";
    echo "3. Verifica que el puerto 587 no esté bloqueado\n";
    echo "4. Revisa los logs en storage/logs/laravel.log\n\n";
    
    echo "📝 Para más detalles del error:\n";
    echo $e->getTraceAsString() . "\n";
}