<?php
/**
 * DEMO: Sistema de Notificaciones Automáticas
 * Geoservi - Sistema de Mantenimiento Minero
 * 
 * Este script simula el envío de notificaciones basadas en horómetros
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Maquinaria;
use App\Models\User;
use App\Models\Pauta;
use App\Services\NotificacionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     DEMO: SISTEMA DE NOTIFICACIONES AUTOMÁTICAS           ║\n";
echo "║            Geoservi - Mantenimiento Minero                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Paso 1: Ejecutar migraciones
echo "📦 PASO 1: Preparando base de datos...\n";
echo "----------------------------------------\n";

try {
    // Ejecutar migración de notificaciones
    Artisan::call('migrate', ['--path' => 'database/migrations/2025_08_26_create_notificaciones_system_tables.php']);
    echo "✅ Tablas de notificaciones creadas\n\n";
} catch (Exception $e) {
    echo "⚠️  Las tablas ya existen o hubo un error: " . $e->getMessage() . "\n\n";
}

// Paso 2: Configurar usuarios para notificaciones
echo "👥 PASO 2: Configurando usuarios para notificaciones...\n";
echo "----------------------------------------\n";

// Actualizar usuario admin
$admin = User::where('email', 'admin@geoservi.cl')->first();
if ($admin) {
    $admin->update([
        'telefono' => '+56912345678',
        'whatsapp' => '+56912345678',
        'notificaciones_activas' => true,
        'rol_notificacion' => 'supervisor'
    ]);
    echo "✅ Usuario admin configurado como supervisor\n";
    echo "   📧 Email: admin@geoservi.cl\n";
    echo "   📱 Teléfono: +56912345678\n";
}

// Crear técnico de ejemplo
$tecnico = User::firstOrCreate(
    ['email' => 'tecnico@geoservi.cl'],
    [
        'name' => 'Juan Técnico',
        'password' => bcrypt('password'),
        'role' => 'tecnico',
        'telefono' => '+56987654321',
        'whatsapp' => '+56987654321',
        'notificaciones_activas' => true,
        'rol_notificacion' => 'tecnico'
    ]
);
echo "✅ Usuario técnico configurado\n";
echo "   📧 Email: tecnico@geoservi.cl\n";
echo "   📱 Teléfono: +56987654321\n\n";

// Paso 3: Simular diferentes escenarios de horómetros
echo "🔧 PASO 3: Configurando escenarios de prueba...\n";
echo "----------------------------------------\n";

// Escenario 1: Máquina con mantención VENCIDA
$maquina1 = Maquinaria::find(1);
if ($maquina1) {
    $maquina1->update(['horometro_actual' => 1600]); // Excede por 100 horas
    echo "🔴 Escenario 1: {$maquina1->nombre}\n";
    echo "   Horómetro: 1,600 hrs (VENCIDO - excede por 100 hrs)\n";
}

// Escenario 2: Máquina CRÍTICA (menos de 24 horas)
$maquina2 = Maquinaria::find(2);
if ($maquina2) {
    $maquina2->update(['horometro_actual' => 980]); // 20 horas para mantención
    echo "🟠 Escenario 2: {$maquina2->nombre}\n";
    echo "   Horómetro: 980 hrs (CRÍTICO - faltan 20 hrs)\n";
}

// Escenario 3: Máquina PREVENTIVA (50 horas)
$maquina3 = Maquinaria::find(3);
if ($maquina3) {
    $maquina3->update(['horometro_actual' => 450]); // 50 horas para mantención
    echo "🟡 Escenario 3: {$maquina3->nombre}\n";
    echo "   Horómetro: 450 hrs (PREVENTIVO - faltan 50 hrs)\n";
}

// Escenario 4: Máquina OK
$maquina4 = Maquinaria::find(4);
if ($maquina4) {
    $maquina4->update(['horometro_actual' => 200]); // 300 horas para mantención
    echo "🟢 Escenario 4: {$maquina4->nombre}\n";
    echo "   Horómetro: 200 hrs (OK - faltan 300 hrs)\n";
}

echo "\n";

// Paso 4: Ejecutar verificación de horómetros
echo "📊 PASO 4: Ejecutando verificación de horómetros...\n";
echo "========================================\n\n";

// Ejecutar comando de verificación
Artisan::call('notificaciones:verificar-horometros');
$output = Artisan::output();
echo $output;

// Paso 5: Mostrar resumen de notificaciones
echo "\n📈 PASO 5: Resumen de notificaciones enviadas\n";
echo "----------------------------------------\n";

$notificaciones = DB::table('notificacion_envios')
    ->select('tipo', 'canal', DB::raw('count(*) as total'))
    ->groupBy('tipo', 'canal')
    ->get();

if ($notificaciones->count() > 0) {
    echo "\n┌─────────────────┬──────────┬─────────┐\n";
    echo "│ Tipo            │ Canal    │ Total   │\n";
    echo "├─────────────────┼──────────┼─────────┤\n";
    
    foreach ($notificaciones as $notif) {
        $tipo = str_pad(ucfirst($notif->tipo), 15);
        $canal = str_pad(ucfirst($notif->canal), 8);
        $total = str_pad($notif->total, 7);
        echo "│ {$tipo} │ {$canal} │ {$total} │\n";
    }
    echo "└─────────────────┴──────────┴─────────┘\n";
} else {
    echo "ℹ️  No se enviaron notificaciones (puede que ya se hayan enviado recientemente)\n";
}

// Paso 6: Mostrar últimas notificaciones
echo "\n📬 Últimas notificaciones enviadas:\n";
echo "----------------------------------------\n";

$ultimasNotificaciones = DB::table('notificacion_envios')
    ->join('maquinarias', 'notificacion_envios.maquinaria_id', '=', 'maquinarias.id')
    ->join('users', 'notificacion_envios.usuario_id', '=', 'users.id')
    ->select(
        'maquinarias.nombre as maquina',
        'users.name as usuario',
        'notificacion_envios.tipo',
        'notificacion_envios.canal',
        'notificacion_envios.estado',
        'notificacion_envios.created_at'
    )
    ->orderBy('notificacion_envios.created_at', 'desc')
    ->limit(5)
    ->get();

foreach ($ultimasNotificaciones as $notif) {
    $emoji = $notif->tipo === 'critica' ? '🔴' : '🟡';
    echo "\n{$emoji} {$notif->maquina}\n";
    echo "   → {$notif->usuario} ({$notif->canal})\n";
    echo "   Estado: {$notif->estado}\n";
    echo "   Fecha: {$notif->created_at}\n";
}

// Paso 7: Información sobre automatización
echo "\n\n⚙️  AUTOMATIZACIÓN CONFIGURADA:\n";
echo "========================================\n";
echo "✅ Verificación cada hora (6:00 - 22:00) días laborales\n";
echo "✅ Verificación cada 6 horas los fines de semana\n";
echo "✅ Resumen diario a las 7:30 AM\n";
echo "✅ Reporte semanal los lunes a las 8:00 AM\n";
echo "✅ Re-envío de críticas no atendidas cada 2 horas\n";

echo "\n📝 NOTAS IMPORTANTES:\n";
echo "----------------------------------------\n";
echo "• Las notificaciones críticas se envían por Email + SMS + WhatsApp\n";
echo "• Las notificaciones preventivas se envían por Email + WhatsApp\n";
echo "• El sistema evita spam: no re-envía si ya notificó recientemente\n";
echo "• Los supervisores reciben escalamiento si no hay respuesta\n";

echo "\n🚀 PRÓXIMOS PASOS:\n";
echo "----------------------------------------\n";
echo "1. Configurar SMTP real en .env para emails\n";
echo "2. Configurar Twilio para SMS/WhatsApp (opcional)\n";
echo "3. Activar cron job: * * * * * php artisan schedule:run\n";
echo "4. Personalizar plantillas de email en resources/views/emails/\n";
echo "5. Configurar preferencias de cada usuario en el panel\n";

echo "\n✨ Demo completado exitosamente!\n\n";

// Mostrar ejemplo de comando manual
echo "💡 TIP: Puedes ejecutar manualmente:\n";
echo "   php artisan notificaciones:verificar-horometros\n";
echo "   php artisan notificaciones:verificar-horometros --maquinaria=1\n";
echo "   php artisan notificaciones:verificar-horometros --force\n";
echo "\n";
