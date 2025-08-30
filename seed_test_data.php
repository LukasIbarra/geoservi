<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Maquinaria;
use App\Models\Pauta;
use App\Models\PautaArea;
use App\Models\PautaItem;
use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoItem;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

try {
    // Crear una maquinaria si no existe
    $maquinaria = Maquinaria::firstOrCreate(
        ['nombre' => 'Excavadora CAT 320'],
        [
            'modelo' => 'CAT 320',
            'marca' => 'Caterpillar',
            'serie' => 'CAT320-001',  // Cambiado de numero_serie a serie
            'horometro_actual' => 1500,
            'fecha_compra' => now()->subMonths(6),  // Agregado fecha_compra
            'estado' => 'activo'
        ]
    );
    echo "Maquinaria creada/encontrada: {$maquinaria->nombre} (ID: {$maquinaria->id})\n";

    // Crear una pauta si no existe
    $pauta = Pauta::firstOrCreate(
        ['nombre' => 'Mantención 250 Horas'],
        [
            'tipo_equipo' => 'maquinaria',  // Cambiado de 'excavadora' a 'maquinaria'
            'frecuencia_horas' => 250,  // Cambiado de 'horas_aplicacion' a 'frecuencia_horas'
            'descripcion' => 'Mantención preventiva cada 250 horas'
        ]
    );
    echo "Pauta creada/encontrada: {$pauta->nombre} (ID: {$pauta->id})\n";

    // Crear áreas para la pauta
    $areaMotor = PautaArea::firstOrCreate(
        [
            'pauta_id' => $pauta->id,
            'nombre' => 'Motor'
        ]
    );
    echo "Área Motor creada/encontrada (ID: {$areaMotor->id})\n";

    $areaPuntosCalientes = PautaArea::firstOrCreate(
        [
            'pauta_id' => $pauta->id,
            'nombre' => 'Puntos Calientes'
        ]
    );
    echo "Área Puntos Calientes creada/encontrada (ID: {$areaPuntosCalientes->id})\n";

    // Crear items para el área Motor
    $itemsMotor = [
        'Revisar nivel de aceite del motor',
        'Verificar filtro de aire',
        'Inspeccionar correas',
        'Revisar sistema de enfriamiento',
        'Verificar fugas de aceite'
    ];

    foreach ($itemsMotor as $desc) {
        PautaItem::firstOrCreate(
            [
                'pauta_area_id' => $areaMotor->id,
                'descripcion' => $desc
            ],
            [
                'tipo' => 'chequeo'
            ]
        );
    }
    echo "Items de Motor creados\n";

    // Crear items para el área Puntos Calientes
    $itemsPuntosCalientes = [
        'Revisar temperatura del motor',
        'Verificar temperatura hidráulica',
        'Inspeccionar radiador',
        'Revisar ventilador'
    ];

    foreach ($itemsPuntosCalientes as $desc) {
        PautaItem::firstOrCreate(
            [
                'pauta_area_id' => $areaPuntosCalientes->id,
                'descripcion' => $desc
            ],
            [
                'tipo' => 'chequeo'
            ]
        );
    }
    echo "Items de Puntos Calientes creados\n";

    // Obtener el ID del usuario administrador
    $adminUser = \App\Models\User::where('email', 'admin@geoservi.cl')->first();
    if (!$adminUser) {
        // Si no existe, crear uno
        $adminUser = \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@geoservi.cl',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);
    }
    
    // Crear una orden de trabajo
    $orden = OrdenTrabajo::create([
        'maquinaria_id' => $maquinaria->id,
        'pauta_id' => $pauta->id,
        'tecnico_id' => $adminUser->id, // Usar el ID del usuario admin
        'fecha_inicio' => now(),
        'horometro_en_ejecucion' => 1500,
        'estado' => 'pendiente',
        'observaciones' => 'Orden de prueba para verificar checklist'
    ]);
    echo "Orden de trabajo creada (ID: {$orden->id})\n";

    // Crear items de la orden basados en los items de la pauta
    $pautaItems = PautaItem::whereIn('pauta_area_id', [$areaMotor->id, $areaPuntosCalientes->id])->get();
    
    foreach ($pautaItems as $pautaItem) {
        OrdenTrabajoItem::create([
            'orden_id' => $orden->id,
            'pauta_item_id' => $pautaItem->id,
            'cumplido' => false,
            'comentario' => null
        ]);
    }
    echo "Items de orden de trabajo creados: " . $pautaItems->count() . "\n";

    DB::commit();
    echo "\n✅ Datos de prueba creados exitosamente!\n";
    echo "Puedes acceder al checklist en: /admin/ordenes/{$orden->id}/checklist\n";

} catch (\Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
