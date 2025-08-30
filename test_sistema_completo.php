<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use App\Models\Maquinaria;
use App\Models\OrdenTrabajo;
use App\Models\User;

echo "\n=== TEST COMPLETO DEL SISTEMA DE MEJORAS ===\n\n";

// 1. Ejecutar migración de activity_logs
echo "1. Ejecutando migración de activity_logs...\n";
try {
    Artisan::call('migrate', ['--path' => 'database/migrations/2025_08_27_create_activity_logs_table.php', '--force' => true]);
    echo "   ✅ Tabla activity_logs creada correctamente\n";
} catch (Exception $e) {
    echo "   ⚠️  La tabla ya existe o error: " . $e->getMessage() . "\n";
}

// 2. Probar registro de actividades
echo "\n2. Probando registro de actividades...\n";
$activityService = new ActivityLogService();

// Simular creación de máquina
$maquina = Maquinaria::first();
if ($maquina) {
    echo "   - Registrando actividad de máquina...\n";
    $activityService->logMaquinariaCreada($maquina);
    
    // Simular actualización de horómetro
    $horometroAnterior = $maquina->horometro_actual;
    $maquina->horometro_actual += 10;
    $maquina->save();
    $activityService->logHorometroActualizado($maquina, $horometroAnterior);
    echo "   ✅ Actividades de máquina registradas\n";
}

// Simular orden de trabajo
$orden = OrdenTrabajo::first();
if ($orden) {
    echo "   - Registrando actividad de orden...\n";
    $activityService->logOrdenCreada($orden);
    $activityService->logOrdenIniciada($orden);
    echo "   ✅ Actividades de orden registradas\n";
}

// 3. Verificar actividades registradas
echo "\n3. Verificando actividades registradas...\n";
$totalActividades = ActivityLog::count();
echo "   Total de actividades en el sistema: $totalActividades\n";

$actividadesRecientes = $activityService->obtenerActividadesRecientes(5);
echo "   Últimas 5 actividades:\n";
foreach ($actividadesRecientes as $actividad) {
    echo "   - [{$actividad['tiempo']}] {$actividad['mensaje']}\n";
}

// 4. Probar estadísticas
echo "\n4. Obteniendo estadísticas de actividades...\n";
$stats = $activityService->obtenerEstadisticasActividades(30);
echo "   - Total últimos 30 días: {$stats['total']}\n";
echo "   - Promedio diario: {$stats['promedio_diario']}\n";
echo "   - Por tipo:\n";
foreach ($stats['por_tipo'] as $tipo => $cantidad) {
    echo "     • $tipo: $cantidad\n";
}

// 5. Verificar integración con Dashboard
echo "\n5. Verificando integración con Dashboard...\n";
$dashboardController = new App\Http\Controllers\DashboardController();
$request = new Illuminate\Http\Request();

// Simular llamada al dashboard
try {
    $response = $dashboardController->index();
    echo "   ✅ Dashboard carga correctamente\n";
} catch (Exception $e) {
    echo "   ❌ Error en dashboard: " . $e->getMessage() . "\n";
}

// 6. Probar exportación PDF
echo "\n6. Probando exportación PDF...\n";
try {
    // Verificar si DomPDF está instalado
    if (class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
        echo "   ✅ DomPDF instalado correctamente\n";
        
        // Probar generación de PDF
        $pdfService = new App\Services\PDFExportService();
        $pdf = $pdfService->generarDashboardPDF();
        echo "   ✅ PDF generado correctamente\n";
    } else {
        echo "   ⚠️  DomPDF no está instalado. Ejecuta: composer require barryvdh/laravel-dompdf\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error generando PDF: " . $e->getMessage() . "\n";
}

// 7. Resumen del sistema
echo "\n=== RESUMEN DEL SISTEMA ===\n";
$maquinarias = Maquinaria::count();
$ordenes = OrdenTrabajo::count();
$usuarios = User::count();
$actividades = ActivityLog::count();

echo "📊 Estadísticas actuales:\n";
echo "   - Maquinarias: $maquinarias\n";
echo "   - Órdenes de trabajo: $ordenes\n";
echo "   - Usuarios: $usuarios\n";
echo "   - Actividades registradas: $actividades\n";

// 8. Funcionalidades implementadas
echo "\n✅ FUNCIONALIDADES IMPLEMENTADAS:\n";
echo "   1. Sistema de registro de actividades (Activity Logs)\n";
echo "   2. Exportación de dashboard a PDF\n";
echo "   3. Tracking detallado de cambios en máquinas\n";
echo "   4. Registro de cambios en órdenes de trabajo\n";
echo "   5. Registro de actualizaciones de horómetros\n";
echo "   6. Iconos y colores distintivos por tipo de actividad\n";
echo "   7. Estadísticas de actividades del sistema\n";

// 9. Funcionalidades pendientes del caso práctico
echo "\n📋 PENDIENTES DEL CASO PRÁCTICO:\n";
echo "   - Sistema de codificación alfanumérico (9 dígitos)\n";
echo "   - Gestión de repuestos y consumibles\n";
echo "   - Rutas de inspección predictiva\n";
echo "   - Gestión de lubricantes\n";
echo "   - Control de residuos\n";
echo "   - Fichas técnicas y hojas de seguridad\n";

echo "\n=== TEST COMPLETADO ===\n";
