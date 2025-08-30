<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoItem;

// Simular lo que hace el controlador
$ordenTrabajo = OrdenTrabajo::find(1);
if (!$ordenTrabajo) {
    die("No se encontró la orden de trabajo #1\n");
}

$orden = $ordenTrabajo->load(['maquinaria:id,nombre', 'pauta:id,nombre']);
echo "Orden cargada:\n";
echo "  ID: {$orden->id}\n";
echo "  Maquinaria: " . ($orden->maquinaria ? $orden->maquinaria->nombre : 'N/A') . "\n";
echo "  Pauta: " . ($orden->pauta ? $orden->pauta->nombre : 'N/A') . "\n\n";

// Traer items de la orden con su pauta_item y área
$otItems = OrdenTrabajoItem::with(['item.area'])->where('orden_id', $orden->id)->get();
echo "Items encontrados: " . $otItems->count() . "\n\n";

$areas = [];
foreach ($otItems as $ot) {
    echo "Procesando item ID: {$ot->id}\n";
    
    // Verificar que el item existe
    if (!$ot->item) {
        echo "  - WARNING: Item no existe\n";
        continue;
    }
    
    echo "  - Descripción del item: {$ot->item->descripcion}\n";
    
    $area = $ot->item->area;
    $areaId = $area ? $area->id : 0;
    
    echo "  - Área: " . ($area ? "#{$area->id} {$area->nombre}" : "Sin área") . "\n";
    
    if (!isset($areas[$areaId])) {
        $areas[$areaId] = [
            'id' => $areaId,
            'nombre' => $area ? $area->nombre : 'General',
            'items' => [],
        ];
    }
    
    $areas[$areaId]['items'][] = [
        'orden_item_id' => $ot->id,
        'pauta_item_id' => $ot->pauta_item_id,
        'descripcion' => $ot->item->descripcion ?? '',
        'tipo' => $ot->item->tipo ?? '',
        'cumplido' => (bool) $ot->cumplido,
        'comentario' => $ot->comentario ?? '',
    ];
}

$areasList = array_values($areas);

echo "\n=== RESULTADO FINAL ===\n";
echo "Número de áreas: " . count($areasList) . "\n";
foreach ($areasList as $area) {
    echo "Área: {$area['nombre']} (ID: {$area['id']})\n";
    echo "  - Items: " . count($area['items']) . "\n";
    foreach ($area['items'] as $item) {
        echo "    * {$item['descripcion']} (cumplido: " . ($item['cumplido'] ? 'SI' : 'NO') . ")\n";
    }
}

// Convertir a JSON para ver la estructura exacta
echo "\n=== ESTRUCTURA JSON ===\n";
echo json_encode($areasList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
