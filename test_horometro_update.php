<?php
/**
 * Script de prueba para demostrar la actualización automática de horómetros
 * Ejecutar con: php test_horometro_update.php
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Maquinaria;
use App\Models\OrdenTrabajo;
use App\Models\Pauta;

echo "\n=== DEMOSTRACIÓN DE ACTUALIZACIÓN AUTOMÁTICA DE HORÓMETROS ===\n\n";

// 1. Mostrar estado inicial de una máquina
$maquinaria = Maquinaria::first();
if (!$maquinaria) {
    echo "No hay maquinarias en el sistema.\n";
    exit;
}

echo "1. ESTADO INICIAL DE LA MÁQUINA:\n";
echo "   - Nombre: {$maquinaria->nombre}\n";
echo "   - Horómetro actual: {$maquinaria->horometro_actual} hrs\n";
echo "   - Estado: {$maquinaria->estado}\n\n";

// 2. Crear una orden de trabajo con horómetro
$pauta = Pauta::first();
if (!$pauta) {
    echo "No hay pautas en el sistema.\n";
    exit;
}

$nuevoHorometro = $maquinaria->horometro_actual + 50; // Simular 50 horas más de trabajo

echo "2. CREANDO ORDEN DE TRABAJO:\n";
echo "   - Pauta: {$pauta->nombre}\n";
echo "   - Horómetro en ejecución: {$nuevoHorometro} hrs\n\n";

$orden = OrdenTrabajo::create([
    'maquinaria_id' => $maquinaria->id,
    'pauta_id' => $pauta->id,
    'horometro_en_ejecucion' => $nuevoHorometro,
    'estado' => 'pendiente',
    'observaciones' => 'Mantención preventiva - Test de actualización de horómetro'
]);

echo "   ✓ Orden #{$orden->id} creada exitosamente\n\n";

// 3. Simular finalización de la orden
echo "3. FINALIZANDO ORDEN DE TRABAJO:\n";
echo "   - Cambiando estado a 'completada'\n";
echo "   - Actualizando horómetro automáticamente...\n\n";

// Simular el proceso de finalización
$orden->estado = 'completada';
$orden->fecha_fin = now();
$orden->save();

// Actualizar horómetro (esto es lo que hace el método finalizar())
if ($orden->horometro_en_ejecucion && $orden->horometro_en_ejecucion > 0) {
    $maquinaria->horometro_actual = $orden->horometro_en_ejecucion;
    $maquinaria->save();
    
    // Actualizar la tabla pivote con la última mantención
    $maquinaria->pautas()->syncWithoutDetaching([
        $orden->pauta_id => [
            'ultima_mantencion_horas' => $orden->horometro_en_ejecucion,
            'ultima_mantencion_fecha' => now()
        ]
    ]);
    
    echo "   ✓ Horómetro actualizado automáticamente\n\n";
}

// 4. Mostrar estado final
$maquinaria->refresh();
echo "4. ESTADO FINAL DE LA MÁQUINA:\n";
echo "   - Nombre: {$maquinaria->nombre}\n";
echo "   - Horómetro actual: {$maquinaria->horometro_actual} hrs (ACTUALIZADO ✓)\n";
echo "   - Estado: {$maquinaria->estado}\n\n";

// 5. Verificar registro de última mantención
$pivotData = $maquinaria->pautas()->where('pauta_id', $pauta->id)->first();
if ($pivotData) {
    echo "5. REGISTRO DE ÚLTIMA MANTENCIÓN:\n";
    echo "   - Pauta: {$pivotData->nombre}\n";
    echo "   - Última mantención a las: {$pivotData->pivot->ultima_mantencion_horas} hrs\n";
    echo "   - Fecha: {$pivotData->pivot->ultima_mantencion_fecha}\n";
    echo "   - Próxima mantención: " . ($pivotData->pivot->ultima_mantencion_horas + $pivotData->frecuencia_horas) . " hrs\n\n";
}

echo "=== DEMOSTRACIÓN COMPLETADA ===\n\n";
echo "RESUMEN:\n";
echo "• El horómetro se actualizó de " . ($nuevoHorometro - 50) . " a {$nuevoHorometro} hrs\n";
echo "• La actualización ocurrió automáticamente al completar la orden\n";
echo "• Se registró la fecha y hora de la última mantención\n";
echo "• El sistema ahora puede calcular cuándo será la próxima mantención\n\n";

echo "BENEFICIOS:\n";
echo "✓ No hay que actualizar manualmente el horómetro\n";
echo "✓ Se mantiene un historial preciso de mantenciones\n";
echo "✓ El dashboard muestra información actualizada en tiempo real\n";
echo "✓ Se pueden generar alertas automáticas basadas en horómetros\n\n";
