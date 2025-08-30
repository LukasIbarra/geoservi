<?php
/**
 * Script de Configuración de Email para Notificaciones
 * Geoservi - Sistema de Mantenimiento Minero
 * 
 * Este script configura el correo pruebasgeoservi@gmail.com
 * para el envío de notificaciones automáticas
 */

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     CONFIGURACIÓN DE EMAIL PARA NOTIFICACIONES            ║\n";
echo "║            Geoservi - Mantenimiento Minero                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Configuración de Gmail para pruebasgeoservi@gmail.com
$emailConfig = <<<EOT

# ========================================
# CONFIGURACIÓN DE EMAIL - NOTIFICACIONES
# ========================================
# Agregar estas líneas a tu archivo .env

# Configuración de Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pruebasgeoservi@gmail.com
MAIL_PASSWORD="tu_contraseña_de_aplicacion"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=pruebasgeoservi@gmail.com
MAIL_FROM_NAME="Geoservi - Sistema de Mantenimiento"

# Configuración adicional para notificaciones
NOTIFICATION_EMAIL_TO=pruebasgeoservi@gmail.com
NOTIFICATION_EMAIL_CC=
NOTIFICATION_EMAIL_BCC=

EOT;

echo "📧 CONFIGURACIÓN PARA GMAIL\n";
echo "========================================\n";
echo $emailConfig;
echo "\n";

echo "⚠️  IMPORTANTE - PASOS PARA CONFIGURAR GMAIL:\n";
echo "========================================\n";
echo "1. Habilitar verificación en 2 pasos en tu cuenta Gmail:\n";
echo "   • Ve a: https://myaccount.google.com/security\n";
echo "   • Activa 'Verificación en 2 pasos'\n\n";

echo "2. Generar contraseña de aplicación:\n";
echo "   • Ve a: https://myaccount.google.com/apppasswords\n";
echo "   • Selecciona 'Correo' y 'Otro'\n";
echo "   • Nombre: 'Geoservi Notificaciones'\n";
echo "   • Copia la contraseña generada (16 caracteres)\n\n";

echo "3. Reemplazar 'tu_contraseña_de_aplicacion' con la contraseña generada\n\n";

echo "4. Después de actualizar .env, ejecutar:\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n\n";

// Crear archivo de ejemplo .env.notificaciones
$envExample = <<<EOT
# ========================================
# EJEMPLO .env para Notificaciones
# ========================================

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=geoservi
DB_USERNAME=root
DB_PASSWORD=

# Configuración de Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pruebasgeoservi@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=pruebasgeoservi@gmail.com
MAIL_FROM_NAME="Geoservi - Sistema de Mantenimiento"

# Destinatarios de notificaciones
NOTIFICATION_EMAIL_TO=pruebasgeoservi@gmail.com
NOTIFICATION_EMAIL_CC=supervisor@geoservi.cl,jefe.mantenimiento@geoservi.cl
NOTIFICATION_EMAIL_BCC=

# Configuración de notificaciones
NOTIFICATION_ENABLED=true
NOTIFICATION_CRITICAL_HOURS=24
NOTIFICATION_WARNING_HOURS=50
NOTIFICATION_PREVENTIVE_HOURS=100

# Horarios de envío
NOTIFICATION_START_HOUR=6
NOTIFICATION_END_HOUR=22
NOTIFICATION_WEEKEND_ENABLED=false

# Modo debug (muestra más información en logs)
NOTIFICATION_DEBUG=true
EOT;

file_put_contents('.env.notificaciones.example', $envExample);
echo "✅ Archivo .env.notificaciones.example creado\n\n";

// Actualizar configuración de mail en Laravel
$mailConfig = <<<'PHP'
<?php

return [
    'default' => env('MAIL_MAILER', 'smtp'),
    
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME', 'pruebasgeoservi@gmail.com'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],
    
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'pruebasgeoservi@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'Geoservi Notificaciones'),
    ],
    
    // Configuración específica para notificaciones
    'notification' => [
        'to' => env('NOTIFICATION_EMAIL_TO', 'pruebasgeoservi@gmail.com'),
        'cc' => env('NOTIFICATION_EMAIL_CC', ''),
        'bcc' => env('NOTIFICATION_EMAIL_BCC', ''),
    ],
];
PHP;

// Guardar configuración actualizada
file_put_contents('config/mail_notificaciones.php', $mailConfig);
echo "✅ Archivo config/mail_notificaciones.php creado\n\n";

echo "📝 PRUEBA DE CONFIGURACIÓN\n";
echo "========================================\n";
echo "Para probar el envío de correos, ejecuta:\n\n";
echo "php test_email_config.php\n\n";

// Crear script de prueba
$testScript = <<<'PHP'
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
    $maquinaria->horometro_actual = 4980;
    
    $pauta = new stdClass();
    $pauta->id = 1;
    $pauta->nombre = 'Mantenimiento 5000 horas';
    $pauta->frecuencia_horas = 5000;
    
    $horasRestantes = 20;
    
    // Enviar con plantilla
    Mail::send('emails.mantenimiento-critico', [
        'maquinaria' => $maquinaria,
        'pauta' => $pauta,
        'horasRestantes' => $horasRestantes,
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
PHP;

file_put_contents('test_email_config.php', $testScript);
echo "✅ Script test_email_config.php creado\n\n";

echo "🚀 CONFIGURACIÓN RÁPIDA\n";
echo "========================================\n";
echo "1. Copia las líneas de configuración al archivo .env\n";
echo "2. Genera una contraseña de aplicación en Gmail\n";
echo "3. Reemplaza 'tu_contraseña_de_aplicacion' con la contraseña generada\n";
echo "4. Ejecuta: php artisan config:clear\n";
echo "5. Prueba con: php test_email_config.php\n\n";

echo "📚 DOCUMENTACIÓN ADICIONAL\n";
echo "========================================\n";
echo "• Guía de Gmail: https://support.google.com/mail/answer/185833\n";
echo "• Laravel Mail: https://laravel.com/docs/mail\n";
echo "• Troubleshooting: Ver IMPLEMENTACION_NOTIFICACIONES.md\n\n";

echo "✨ Script completado!\n";
