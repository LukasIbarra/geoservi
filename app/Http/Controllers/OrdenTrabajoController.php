<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\Maquinaria;
use App\Models\Pauta;
use App\Models\OrdenTrabajoItem;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinarias = Maquinaria::select('id', 'nombre')->orderBy('nombre')->get();
        $pautas = Pauta::select('id', 'nombre', 'tipo_equipo')->orderBy('nombre')->get();

        return view('admin/ordenes', compact('maquinarias', 'pautas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'maquinaria_id' => 'required|exists:maquinarias,id',
            'pauta_id' => 'required|exists:pautas,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'horometro_en_ejecucion' => 'nullable|numeric|min:0',
            'estado' => 'nullable|in:pendiente,en_progreso,completada,cancelada',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estado'] = $validated['estado'] ?? 'pendiente';

        // Crear OT y snapshot de pauta -> orden_trabajo_items
        $orden = DB::transaction(function () use ($validated) {
            $orden = OrdenTrabajo::create($validated);

            // Cargar pauta con sus áreas e ítems y generar snapshot
            $pauta = Pauta::with(['areas.items'])->findOrFail($validated['pauta_id']);
            $rows = [];
            foreach ($pauta->areas as $area) {
                foreach ($area->items as $it) {
                    $rows[] = [
                        'orden_id' => $orden->id,
                        'pauta_item_id' => $it->id,
                        'cumplido' => false,
                        'comentario' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            if (!empty($rows)) {
                OrdenTrabajoItem::insert($rows);
            }

            return $orden;
        });

        // Registrar actividad
        $activityService = new ActivityLogService();
        $activityService->logOrdenCreada($orden);

        return response()->json([
            'success' => true,
            'message' => 'Orden de trabajo creada exitosamente',
            'data' => $orden->load(['maquinaria:id,nombre','pauta:id,nombre'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrdenTrabajo $ordenTrabajo)
    {
        return response()->json($ordenTrabajo->load(['maquinaria','pauta','tecnico']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdenTrabajo $ordenTrabajo)
    {
        $validated = $request->validate([
            'maquinaria_id' => 'sometimes|exists:maquinarias,id',
            'pauta_id' => 'sometimes|exists:pautas,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'horometro_en_ejecucion' => 'nullable|numeric|min:0',
            'estado' => 'sometimes|in:pendiente,en_progreso,completada,cancelada',
            'observaciones' => 'nullable|string',
        ]);

        // Detectar si cambia el estado para registrar actividad específica
        $estadoAnterior = $ordenTrabajo->estado;
        $ordenTrabajo->update($validated);
        
        // Registrar actividad según el cambio de estado
        $activityService = new ActivityLogService();
        if (isset($validated['estado']) && $validated['estado'] != $estadoAnterior) {
            if ($validated['estado'] == 'en_proceso') {
                $activityService->logOrdenIniciada($ordenTrabajo);
            } elseif ($validated['estado'] == 'completada') {
                $activityService->logOrdenCompletada($ordenTrabajo);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden de trabajo actualizada exitosamente',
            'data' => $ordenTrabajo->load(['maquinaria:id,nombre','pauta:id,nombre'])
        ]);
    }

    public function datatable(Request $request)
    {
        // Base query con relaciones necesarias para mostrar nombres
        $base = OrdenTrabajo::with(['maquinaria:id,nombre', 'pauta:id,nombre', 'tecnico:id,name']);
        $recordsTotal = $base->count();

        // Clone for filters
        $query = clone $base;

        // Búsqueda (custom_search, objeto DataTables search o string simple)
        $searchVal = null;
        if ($request->filled('custom_search')) {
            $searchVal = $request->input('custom_search');
        } elseif ($request->has('search')) {
            $searchVal = is_array($request->search) ? ($request->search['value'] ?? null) : $request->search;
        }
        if (!empty($searchVal)) {
            $sv = "%{$searchVal}%";
            $query->where(function ($q) use ($sv) {
                $q->where('observaciones', 'like', $sv)
                  ->orWhere('estado', 'like', $sv)
                  ->orWhereHas('maquinaria', function ($qq) use ($sv) {
                      $qq->where('nombre', 'like', $sv);
                  })
                  ->orWhereHas('pauta', function ($qq) use ($sv) {
                      $qq->where('nombre', 'like', $sv);
                  })
                  ->orWhereHas('tecnico', function ($qq) use ($sv) {
                      $qq->where('name', 'like', $sv);
                  });
            });
        }

        // Filtros opcionales
        if ($request->filled('estadoFilter')) {
            $query->where('estado', $request->input('estadoFilter'));
        }
        if ($request->filled('maquinariaId')) {
            $query->where('maquinaria_id', $request->input('maquinariaId'));
        }
        if ($request->filled('pautaId')) {
            $query->where('pauta_id', $request->input('pautaId'));
        }

        // Filtro por tipo de maquinaria
        if ($request->filled('tipoMaquinariaFilter')) {
            $query->whereHas('maquinaria', function ($q) use ($request) {
                $q->where('tipo', $request->input('tipoMaquinariaFilter'));
            });
        }

        // Filtros por rango de horómetro
        if ($request->filled('horometroMin') || $request->filled('horometroMax')) {
            $query->where(function ($q) use ($request) {
                if ($request->filled('horometroMin')) {
                    $q->where('horometro_en_ejecucion', '>=', $request->input('horometroMin'));
                }
                if ($request->filled('horometroMax')) {
                    $q->where('horometro_en_ejecucion', '<=', $request->input('horometroMax'));
                }
            });
        }

        // Filtros por rango de fechas de creación
        if ($request->filled('fechaCreacionDesde') || $request->filled('fechaCreacionHasta')) {
            $query->where(function ($q) use ($request) {
                if ($request->filled('fechaCreacionDesde')) {
                    $q->whereDate('created_at', '>=', $request->input('fechaCreacionDesde'));
                }
                if ($request->filled('fechaCreacionHasta')) {
                    $q->whereDate('created_at', '<=', $request->input('fechaCreacionHasta'));
                }
            });
        }

        // Orden
        $allowed = ['id', 'fecha_inicio', 'fecha_fin', 'horometro_en_ejecucion', 'estado', 'created_at'];
        if ($request->has('order') && isset($request->order[0]['column'])) {
            $orderIdx = intval($request->order[0]['column']);
            $column = $request->columns[$orderIdx]['data'] ?? 'created_at';
            $direction = $request->order[0]['dir'] ?? 'desc';
            if (!in_array($column, $allowed)) {
                $column = 'created_at';
            }
            $query->orderBy($column, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Totales
        $recordsFiltered = (clone $query)->count();

        // Paginación
        $start = intval($request->start ?? 0);
        $length = intval($request->length ?? 10);
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    /**
     * Vista de checklist (admin) agrupando por áreas e ítems de la pauta
     */
    public function checklist(OrdenTrabajo $ordenTrabajo)
    {
        $orden = $ordenTrabajo->load(['maquinaria:id,nombre', 'pauta:id,nombre']);
        // Traer items de la orden con su pauta_item y área
        $otItems = OrdenTrabajoItem::with(['item.area'])->where('orden_id', $orden->id)->get();

        $areas = [];
        foreach ($otItems as $ot) {
            // Verificar que el item existe
            if (!$ot->item) {
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

        return view('admin/orden_checklist', compact('orden', 'areasList'));
    }

    /**
     * Actualiza el estado/comentario de un ítem de la OT (AJAX)
     */
    public function updateItem(Request $request, OrdenTrabajoItem $ordenTrabajoItem)
    {
        $data = $request->validate([
            'cumplido' => 'sometimes|boolean',
            'comentario' => 'nullable|string',
        ]);

        $ordenTrabajoItem->update([
            'cumplido' => array_key_exists('cumplido', $data) ? (bool)$data['cumplido'] : $ordenTrabajoItem->cumplido,
            'comentario' => $data['comentario'] ?? $ordenTrabajoItem->comentario,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ítem actualizado',
            'data' => $ordenTrabajoItem->only(['id','orden_id','pauta_item_id','cumplido','comentario'])
        ]);
    }

    /**
     * Finaliza una OT (AJAX)
     */
    public function finalizar(Request $request, OrdenTrabajo $ordenTrabajo)
    {
        $ordenTrabajo->estado = 'completada';
        if (empty($ordenTrabajo->fecha_fin)) {
            // si existe la columna, setear fecha de término
            try { $ordenTrabajo->fecha_fin = now()->toDateString(); } catch (\Throwable $e) {}
        }
        $ordenTrabajo->save();
        
        // Registrar actividad de finalización
        $activityService = new ActivityLogService();
        $activityService->logOrdenCompletada($ordenTrabajo);
        
        // NUEVO: Actualizar horómetro de la maquinaria cuando se finaliza la orden
        if ($ordenTrabajo->horometro_en_ejecucion && $ordenTrabajo->horometro_en_ejecucion > 0) {
            $maquinaria = Maquinaria::find($ordenTrabajo->maquinaria_id);
            if ($maquinaria) {
                $horometroAnterior = $maquinaria->horometro_actual;
                
                // Actualizar el horómetro actual de la maquinaria
                $maquinaria->horometro_actual = $ordenTrabajo->horometro_en_ejecucion;
                $maquinaria->save();
                
                // Registrar actualización de horómetro
                if ($horometroAnterior != $maquinaria->horometro_actual) {
                    $activityService->logHorometroActualizado($maquinaria, $horometroAnterior);
                }
                
                // Actualizar la tabla pivote con la última mantención para esta pauta
                // Esto resetea el contador para que la barra vuelva a verde
                if ($ordenTrabajo->pauta_id) {
                    // Verificar si existe la relación
                    $existingPivot = $maquinaria->pautas()->where('pauta_id', $ordenTrabajo->pauta_id)->first();
                    
                    if ($existingPivot) {
                        // Actualizar registro existente
                        $maquinaria->pautas()->updateExistingPivot($ordenTrabajo->pauta_id, [
                            'ultima_mantencion_horas' => $ordenTrabajo->horometro_en_ejecucion,
                            'ultima_mantencion_fecha' => now()
                        ]);
                    } else {
                        // Crear nuevo registro en la tabla pivot
                        $maquinaria->pautas()->attach($ordenTrabajo->pauta_id, [
                            'ultima_mantencion_horas' => $ordenTrabajo->horometro_en_ejecucion,
                            'ultima_mantencion_fecha' => now()
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden finalizada y horómetro actualizado',
            'data' => $ordenTrabajo->only(['id','estado','fecha_fin'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, OrdenTrabajo $ordenTrabajo)
    {
        $ordenTrabajo->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Orden de trabajo eliminada exitosamente'
            ]);
        }

        return redirect()->route('admin.ordenes.index')->with('success', 'Orden de trabajo eliminada exitosamente');
    }
}
