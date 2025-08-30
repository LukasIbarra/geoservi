<?php
/**
 * Script simplificado de prueba de emails
 * Verifica que el sistema de notificaciones esté funcionando
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\Maquinaria;
use App\Models\Pauta;

echo "\n";
echo "========================================\n";
echo "   PRUEBA SIMPLIFICADA DE EMAILS\n";
echo "   Sistema de Notificaciones Geoservi\n";
echo "========================================\n\n";

// Verificar configuración
$mailConfig = config('mail');
echo "📧 Configuración de Email:\n";
echo "   Host: " . $mailConfig['mailers']['smtp']['host'] . "\n";
echo "   Puerto: " . $mailConfig['mailers']['smtp']['port'] . "\n";
echo "   Usuario: " . $mailConfig['mailers']['smtp']['username'] . "\n";
echo "   Desde: " . $mailConfig['from']['address'] . "\n\n";

// Obtener una máquina real de la base de datos
echo "🔍 Buscando maquinaria en la base de datos...\n";
$maquinaria = Maquinaria::with('pautas')->first();

if (!$maquinaria) {
    echo "❌ No hay maquinarias en la base de datos\n";
    exit(1);
}

echo "✅ Maquinaria encontrada: {$maquinaria->nombre}\n";
echo "   Horómetro actual: " . number_format($maquinaria->horometro_actual) . " hrs\n\n";

// Obtener pauta asociada
$pauta = $maquinaria->pautas->first();
if (!$pauta) {
    // Crear pauta temporal para prueba
    $pauta = new \stdClass();
    $pauta->nombre = 'Mantenimiento de Prueba';
    $pauta->frecuencia_horas = 500;
    $pauta->pivot = new \stdClass();
    $pauta->pivot->ultima_mantencion_horas = $maquinaria->horometro_actual - 480;
}

// Calcular horas restantes
$ultimaMantencion = isset($pauta->pivot) ? ($pauta->pivot->ultima_mantencion_horas ?? 0) : 0;
$proximaMantencion = $ultimaMantencion + $pauta->frecuencia_horas;
$horasRestantes = $proximaMantencion - $maquinaria->horometro_actual;

echo "📊 Información de Mantenimiento:\n";
echo "   Pauta: {$pauta->nombre}\n";
echo "   Frecuencia: cada {$pauta->frecuencia_horas} hrs\n";
echo "   Última mantención: " . number_format($ultimaMantencion) . " hrs\n";
echo "   Próxima mantención: " . number_format($proximaMantencion) . " hrs\n";
echo "   Horas restantes: " . number_format($horasRestantes) . " hrs\n\n";

// Determinar tipo de alerta
$tipoAlerta = '';
$emoji = '';
if ($horasRestantes <= 0) {
    $tipoAlerta = 'CRÍTICA - VENCIDA';
    $emoji = '🔴';
} elseif ($horasRestantes <= 24) {
    $tipoAlerta = 'CRÍTICA';
    $emoji = '🟠';
} elseif ($horasRestantes <= 50) {
    $tipoAlerta = 'PREVENTIVA';
    $emoji = '🟡';
} else {
    $tipoAlerta = 'INFORMATIVA';
    $emoji = '🟢';
}

echo "{$emoji} Estado de Alerta: {$tipoAlerta}\n\n";

// Enviar emails de prueba
echo "📤 ENVIANDO EMAILS DE PRUEBA...\n";
echo "========================================\n\n";

try {
    // 1. Email de texto simple
    echo "1️⃣ Enviando email de texto simple...\n";
    
    Mail::raw("🔧 ALERTA DE MANTENIMIENTO - {$tipoAlerta}

Maquinaria: {$maquinaria->nombre}
Tipo: {$maquinaria->tipo}
Horómetro Actual: " . number_format($maquinaria->horometro_actual) . " hrs
Horas Restantes: " . number_format($horasRestantes) . " hrs

Pauta: {$pauta->nombre}
Frecuencia: Cada {$pauta->frecuencia_horas} horas

Estado: {$tipoAlerta}

---
Sistema de Mantenimiento Preventivo
Geoservi - Soluciones Mineras
Fecha: " . date('Y-m-d H:i:s'), function($message) use ($tipoAlerta) {
        $message->to('pruebasgeoservi@gmail.com')
                ->subject("🔧 {$tipoAlerta} - Notificación de Mantenimiento");
    });
    
    echo "   ✅ Email de texto enviado\n\n";
    
    // 2. Email HTML con plantilla
    echo "2️⃣ Enviando email HTML con plantilla...\n";
    
    // Preparar datos para la plantilla
    $estadoCritico = $horasRestantes <= 0 ? 'VENCIDO' : ($horasRestantes <= 24 ? 'CRÍTICO' : 'PREVENTIVO');
    $accionRequerida = $horasRestantes <= 0 
        ? 'DETENER OPERACIÓN INMEDIATAMENTE - Mantenimiento vencido por ' . abs($horasRestantes) . ' horas'
        : ($horasRestantes <= 24 
            ? 'Programar mantenimiento URGENTE en las próximas ' . $horasRestantes . ' horas'
            : 'Programar mantenimiento preventivo en los próximos días');
    
    // Asegurar que maquinaria tenga todos los campos necesarios
    if (!isset($maquinaria->marca)) $maquinaria->marca = 'N/A';
    if (!isset($maquinaria->modelo)) $maquinaria->modelo = 'N/A';
    if (!isset($maquinaria->serie)) $maquinaria->serie = 'N/A';
    
    Mail::send('emails.mantenimiento-critico', [
        'maquinaria' => $maquinaria,
        'pauta' => $pauta,
        'horasRestantes' => $horasRestantes,
        'estadoCritico' => $estadoCritico,
        'accionRequerida' => $accionRequerida,
        'urlAccion' => url('/admin/ordenes/crear'),
        'urlMaquinaria' => url('/admin/maquinarias/' . $maquinaria->id),
    ], function($message) use ($tipoAlerta) {
        $message->to('pruebasgeoservi@gmail.com')
        ->subject("{$tipoAlerta} - Mantenimiento Requerido");
    });
    
    echo "   ✅ Email HTML enviado\n\n";
    
    // 3. Email preventivo (si aplica)
    if ($horasRestantes > 24 && $horasRestantes <= 100) {
        echo "3️⃣ Enviando email preventivo...\n";
        
        Mail::send('emails.mantenimiento-preventivo', [
            'maquinaria' => $maquinaria,
            'pauta' => $pauta,
            'horasRestantes' => $horasRestantes,
            'diasRestantes' => round($horasRestantes / 24, 1),
            'urlAccion' => url('/admin/ordenes/crear'),
            'urlMaquinaria' => url('/admin/maquinarias/' . $maquinaria->id),
        ], function($message) {
            $message->to('pruebasgeoservi@gmail.com')
                    ->subject('📋 Mantenimiento Preventivo Programado');
        });
        
        echo "   ✅ Email preventivo enviado\n\n";
    }
    
    echo "========================================\n";
    echo "✅ TODAS LAS PRUEBAS COMPLETADAS\n";
    echo "========================================\n\n";
    
    echo "📬 Revisa la bandeja de entrada de:\n";
    echo "   pruebasgeoservi@gmail.com\n\n";
    
    echo "📝 Deberías haber recibido:\n";
    echo "   • 1 email de texto simple\n";
    echo "   • 1 email HTML con diseño profesional\n";
    if ($horasRestantes > 24 && $horasRestantes <= 100) {
        echo "   • 1 email preventivo\n";
    }
    echo "\n";
    
    echo "💡 Si los emails llegaron correctamente:\n";
    echo "   ✓ La configuración SMTP está funcionando\n";
    echo "   ✓ Las plantillas están correctas\n";
    echo "   ✓ El sistema está listo para producción\n\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR al enviar emails:\n";
    echo "   " . $e->getMessage() . "\n\n";
    
    echo "🔧 POSIBLES SOLUCIONES:\n";
    echo "1. Verifica tu archivo .env:\n";
    echo "   MAIL_MAILER=smtp\n";
    echo "   MAIL_HOST=smtp.gmail.com\n";
    echo "   MAIL_PORT=587\n";
    echo "   MAIL_USERNAME=pruebasgeoservi@gmail.com\n";
    echo "   MAIL_PASSWORD=\"tu-contraseña-de-aplicación\"\n";
    echo "   MAIL_ENCRYPTION=tls\n";
    echo "   MAIL_FROM_ADDRESS=pruebasgeoservi@gmail.com\n\n";
    
    echo "2. Asegúrate de tener una contraseña de aplicación de Gmail\n";
    echo "3. Verifica tu conexión a internet\n";
    echo "4. Ejecuta: php artisan config:clear\n\n";
    
    echo "📝 Detalles del error:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n";
