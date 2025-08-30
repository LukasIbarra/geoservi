<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoItem;
use App\Models\PautaItem;
use App\Models\PautaArea;

// Verificar órdenes de trabajo
$ordenes = OrdenTrabajo::with(['maquinaria', 'pauta'])->get();
echo "Total de órdenes de trabajo: " . $ordenes->count() . "\n\n";

foreach ($ordenes as $orden) {
    echo "Orden #{$orden->id}:\n";
    echo "  - Maquinaria: " . ($orden->maquinaria ? $orden->maquinaria->nombre : 'N/A') . "\n";
    echo "  - Pauta: " . ($orden->pauta ? $orden->pauta->nombre : 'N/A') . "\n";
    
    // Verificar items de la orden
    $items = OrdenTrabajoItem::where('orden_id', $orden->id)->count();
    echo "  - Items asociados: {$items}\n";
    
    if ($items > 0) {
        $otItems = OrdenTrabajoItem::with(['item.area'])->where('orden_id', $orden->id)->get();
        $areas = [];
        foreach ($otItems as $ot) {
            if ($ot->item && $ot->item->area) {
                $areaName = $ot->item->area->nombre;
                if (!isset($areas[$areaName])) {
                    $areas[$areaName] = 0;
                }
                $areas[$areaName]++;
            }
        }
        
        if (!empty($areas)) {
            echo "  - Áreas con items:\n";
            foreach ($areas as $areaName => $count) {
                echo "    * {$areaName}: {$count} items\n";
            }
        }
    }
    echo "\n";
}

// Verificar pautas y sus items
$pautas = \App\Models\Pauta::with(['areas.items'])->get();
echo "\n=== PAUTAS Y SUS ITEMS ===\n";
foreach ($pautas as $pauta) {
    echo "Pauta: {$pauta->nombre}\n";
    foreach ($pauta->areas as $area) {
        echo "  - Área: {$area->nombre} ({$area->items->count()} items)\n";
    }
}
