<?php
/**
 * Script de prueba para verificar el reseteo de horómetros
 * al completar una orden de trabajo
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Maquinaria;
use App\Models\OrdenTrabajo;
use App\Models\Pauta;
use Illuminate\Support\Facades\DB;

echo "\n";
echo "========================================\n";
echo "   PRUEBA DE RESETEO DE HORÓMETROS\n";
echo "========================================\n\n";

// Buscar el camión con horómetro vencido
$maquinaria = Maquinaria::where('nombre', 'like', '%Camion%')->first();

if (!$maquinaria) {
    echo "❌ No se encontró el camión\n";
    exit(1);
}

echo "📊 Estado ANTES de la mantención:\n";
echo "   Maquinaria: {$maquinaria->nombre}\n";
echo "   Horómetro actual: " . number_format($maquinaria->horometro_actual) . " hrs\n\n";

// Obtener la pauta asociada
$pauta = $maquinaria->pautas()->first();
if ($pauta) {
    $pivot = $maquinaria->pautas()->where('pauta_id', $pauta->id)->first()->pivot;
    $ultimaMantencion = $pivot->ultima_mantencion_horas ?? 0;
    $proximaMantencion = $ultimaMantencion + $pauta->frecuencia_horas;
    $horasRestantes = $proximaMantencion - $maquinaria->horometro_actual;
    
    echo "   Pauta: {$pauta->nombre}\n";
    echo "   Frecuencia: cada {$pauta->frecuencia_horas} hrs\n";
    echo "   Última mantención: " . number_format($ultimaMantencion) . " hrs\n";
    echo "   Próxima mantención: " . number_format($proximaMantencion) . " hrs\n";
    echo "   Horas restantes: " . number_format($horasRestantes) . " hrs\n";
    
    if ($horasRestantes <= 0) {
        echo "   ⚠️ Estado: VENCIDO (barra roja)\n";
    } elseif ($horasRestantes <= 50) {
        echo "   ⚠️ Estado: CRÍTICO (barra amarilla)\n";
    } else {
        echo "   ✅ Estado: OK (barra verde)\n";
    }
}

echo "\n========================================\n";
echo "SIMULANDO COMPLETAR ORDEN DE TRABAJO...\n";
echo "========================================\n\n";

// Buscar una orden pendiente o crear una nueva
$orden = OrdenTrabajo::where('maquinaria_id', $maquinaria->id)
    ->where('estado', '!=', 'completada')
    ->first();

if (!$orden && $pauta) {
    echo "📝 Creando nueva orden de trabajo...\n";
    $orden = OrdenTrabajo::create([
        'maquinaria_id' => $maquinaria->id,
        'pauta_id' => $pauta->id,
        'fecha_inicio' => now(),
        'horometro_en_ejecucion' => $maquinaria->horometro_actual + 10, // Simulamos 10 horas más
        'estado' => 'pendiente', // Usar 'pendiente' en lugar de 'en_proceso'
        'observaciones' => 'Orden de prueba para reseteo de horómetro'
    ]);
    echo "   ✅ Orden creada: #{$orden->id}\n";
} elseif ($orden) {
    echo "📝 Usando orden existente: #{$orden->id}\n";
    // Actualizar el horómetro de ejecución
    $orden->horometro_en_ejecucion = $maquinaria->horometro_actual + 10;
    $orden->save();
}

if ($orden) {
    echo "   Horómetro al finalizar: " . number_format($orden->horometro_en_ejecucion) . " hrs\n\n";
    
    // Simular finalización de la orden
    echo "🔧 Finalizando orden de trabajo...\n";
    
    // Ejecutar la lógica de finalización
    $orden->estado = 'completada';
    $orden->fecha_fin = now();
    $orden->save();
    
    // Actualizar horómetro de la maquinaria
    if ($orden->horometro_en_ejecucion && $orden->horometro_en_ejecucion > 0) {
        $maquinaria->horometro_actual = $orden->horometro_en_ejecucion;
        $maquinaria->save();
        
        // Actualizar la tabla pivote
        if ($orden->pauta_id) {
            $existingPivot = $maquinaria->pautas()->where('pauta_id', $orden->pauta_id)->first();
            
            if ($existingPivot) {
                $maquinaria->pautas()->updateExistingPivot($orden->pauta_id, [
                    'ultima_mantencion_horas' => $orden->horometro_en_ejecucion,
                    'ultima_mantencion_fecha' => now()
                ]);
                echo "   ✅ Registro de mantención actualizado\n";
            } else {
                $maquinaria->pautas()->attach($orden->pauta_id, [
                    'ultima_mantencion_horas' => $orden->horometro_en_ejecucion,
                    'ultima_mantencion_fecha' => now()
                ]);
                echo "   ✅ Registro de mantención creado\n";
            }
        }
    }
    
    echo "\n========================================\n";
    echo "📊 Estado DESPUÉS de la mantención:\n";
    echo "========================================\n\n";
    
    // Recargar datos
    $maquinaria->refresh();
    $pauta = $maquinaria->pautas()->where('pauta_id', $orden->pauta_id)->first();
    
    echo "   Maquinaria: {$maquinaria->nombre}\n";
    echo "   Horómetro actual: " . number_format($maquinaria->horometro_actual) . " hrs\n\n";
    
    if ($pauta) {
        $pivot = $pauta->pivot;
        $ultimaMantencion = $pivot->ultima_mantencion_horas ?? 0;
        $proximaMantencion = $ultimaMantencion + $pauta->frecuencia_horas;
        $horasRestantes = $proximaMantencion - $maquinaria->horometro_actual;
        
        echo "   Última mantención: " . number_format($ultimaMantencion) . " hrs\n";
        echo "   Próxima mantención: " . number_format($proximaMantencion) . " hrs\n";
        echo "   Horas restantes: " . number_format($horasRestantes) . " hrs\n";
        
        if ($horasRestantes <= 0) {
            echo "   ❌ Estado: VENCIDO (barra roja)\n";
            echo "\n   ⚠️ PROBLEMA: El horómetro no se resetó correctamente\n";
        } elseif ($horasRestantes <= 50) {
            echo "   ⚠️ Estado: CRÍTICO (barra amarilla)\n";
        } else {
            echo "   ✅ Estado: OK (barra verde)\n";
            echo "\n   🎉 ÉXITO: El contador se resetó correctamente!\n";
            echo "   La barra debería aparecer verde en el dashboard\n";
        }
    }
    
    echo "\n========================================\n";
    echo "💡 RESUMEN:\n";
    echo "========================================\n";
    echo "• Orden #{$orden->id} completada\n";
    echo "• Horómetro actualizado a " . number_format($maquinaria->horometro_actual) . " hrs\n";
    echo "• Próxima mantención en " . number_format($horasRestantes) . " hrs\n";
    echo "\nRevisa el dashboard para confirmar que la barra\n";
    echo "del camión ahora aparece en verde.\n";
} else {
    echo "❌ No se pudo crear/encontrar una orden de trabajo\n";
}

echo "\n";
