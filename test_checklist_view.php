<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoItem;

$orden = OrdenTrabajo::with(['maquinaria:id,nombre', 'pauta:id,nombre'])->find(3);
if (!$orden) {
    echo "Orden #3 no encontrada\n";
    exit;
}

echo "=== ORDEN #3 ===\n";
echo "ID: {$orden->id}\n";
echo "Maquinaria: " . ($orden->maquinaria ? $orden->maquinaria->nombre : 'N/A') . "\n";
echo "Pauta: " . ($orden->pauta ? $orden->pauta->nombre : 'N/A') . "\n\n";

// Obtener items con sus relaciones
$otItems = OrdenTrabajoItem::with(['item.area'])->where('orden_id', $orden->id)->get();
echo "Total de items en la orden: " . $otItems->count() . "\n\n";

// Agrupar por áreas como lo hace el controlador
$areas = [];
foreach ($otItems as $ot) {
    if (!$ot->item) {
        echo "WARNING: Item sin relación PautaItem (ID: {$ot->id})\n";
        continue;
    }
    
    $area = $ot->item->area;
    $areaId = $area ? $area->id : 0;
    
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

echo "=== ÁREAS AGRUPADAS ===\n";
echo "Total de áreas: " . count($areasList) . "\n\n";

foreach ($areasList as $idx => $area) {
    echo "Área {$idx}: {$area['nombre']} (ID: {$area['id']})\n";
    echo "  Total items: " . count($area['items']) . "\n";
    foreach ($area['items'] as $i => $item) {
        echo "    Item {$i}: {$item['descripcion']}\n";
        echo "      - Tipo: {$item['tipo']}\n";
        echo "      - Cumplido: " . ($item['cumplido'] ? 'Sí' : 'No') . "\n";
        echo "      - orden_item_id: {$item['orden_item_id']}\n";
    }
    echo "\n";
}

// Verificar el JSON que se pasaría a la vista
echo "=== JSON PARA LA VISTA ===\n";
echo "areasList JSON:\n";
echo json_encode($areasList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
