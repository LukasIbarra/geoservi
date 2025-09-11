<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use App\Models\Pauta;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaquinariaController extends Controller
{
    public function index()
    {
        return view('admin/maquinarias');
    }
    
    public function datatable(Request $request)
    {
        // Base query
        $base = Maquinaria::query();
        $recordsTotal = $base->count();

        // Clone for applying filters
        $query = clone $base;

        // Aplicar filtros de búsqueda (soporta objeto DataTables, string simple y filtros personalizados)
        $searchVal = null;
        if ($request->filled('custom_search')) {
            $searchVal = $request->input('custom_search');
        } elseif ($request->has('search')) {
            $searchVal = is_array($request->search) ? ($request->search['value'] ?? null) : $request->search;
        }
        if (!empty($searchVal)) {
            $query->where(function ($q) use ($searchVal) {
                $q->where('nombre', 'like', "%{$searchVal}%")
                    ->orWhere('marca', 'like', "%{$searchVal}%")
                    ->orWhere('modelo', 'like', "%{$searchVal}%")
                    ->orWhere('serie', 'like', "%{$searchVal}%");
            });
        }

        // Filtro de estado (soporta estadoFilter personalizado y 'estado' estándar)
        if ($request->filled('estadoFilter')) {
            $query->where('estado', $request->input('estadoFilter'));
        } elseif ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtros avanzados
        // Filtro de horómetro mínimo
        if ($request->filled('horometroMin')) {
            $query->where('horometro_actual', '>=', $request->input('horometroMin'));
        }

        // Filtro de horómetro máximo
        if ($request->filled('horometroMax')) {
            $query->where('horometro_actual', '<=', $request->input('horometroMax'));
        }

        // Filtro de fecha de compra desde
        if ($request->filled('fechaCompraDesde')) {
            $query->where('fecha_compra', '>=', $request->input('fechaCompraDesde'));
        }

        // Filtro de fecha de compra hasta
        if ($request->filled('fechaCompraHasta')) {
            $query->where('fecha_compra', '<=', $request->input('fechaCompraHasta'));
        }

        // Filtro de fecha de creación desde
        if ($request->filled('fechaCreacionDesde')) {
            $query->where('created_at', '>=', $request->input('fechaCreacionDesde') . ' 00:00:00');
        }

        // Filtro de fecha de creación hasta
        if ($request->filled('fechaCreacionHasta')) {
            $query->where('created_at', '<=', $request->input('fechaCreacionHasta') . ' 23:59:59');
        }

        // Ordenamiento (evitar columnas no ordenables como las calculadas)
        $allowed = ['id', 'nombre', 'tipo', 'marca', 'modelo', 'horometro_actual', 'estado', 'created_at'];
        if ($request->has('order') && isset($request->order[0]['column'])) {
            $orderIdx = intval($request->order[0]['column']);
            $column = $request->columns[$orderIdx]['data'] ?? 'nombre';
            $direction = $request->order[0]['dir'] ?? 'asc';
            if (!in_array($column, $allowed)) {
                $column = 'nombre';
            }
            $query->orderBy($column, $direction);
        } else {
            $query->orderBy('nombre', 'asc');
        }

        // Totales
        $recordsFiltered = $query->count();

        // Paginación
        $start = intval($request->start ?? 0);
        $length = intval($request->length ?? 10);
        $maquinarias = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $maquinarias
        ]);
    }
    
    public function create()
    {
        $pautas = Pauta::all();
        return view('maquinarias.create', compact('pautas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:camion,excavadora,cargador,otro',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'serie' => 'nullable|string|max:255|unique:maquinarias,serie',
            'horometro_actual' => 'nullable|numeric|min:0',
            'estado' => 'nullable|in:activo,inactivo,mantencion',
            'fecha_compra' => 'nullable|date'
        ]);

        try {
            $maquinaria = Maquinaria::create([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'serie' => $request->serie ?? 'SER-' . strtoupper(uniqid()),
                'horometro_actual' => $request->horometro_actual ?? 0,
                'horometro_acumulado' => 0,
                'fecha_compra' => $request->fecha_compra ?? now(),
                'estado' => $request->estado ?? 'activo'
            ]);

            // Registrar actividad
            $activityService = new ActivityLogService();
            $activityService->logMaquinariaCreada($maquinaria);

            return response()->json([
                'success' => true,
                'message' => 'Maquinaria creada exitosamente',
                'data' => $maquinaria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la maquinaria: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show(Maquinaria $maquinaria)
    {
        $proximosMantenimientos = $this->calcularProximosMantenimientos($maquinaria);
        return view('maquinarias.show', compact('maquinaria', 'proximosMantenimientos'));
    }
    
    public function edit(Maquinaria $maquinaria)
    {
        $pautas = Pauta::all();
        $pautasAsignadas = $maquinaria->pautas->pluck('id')->toArray();
        return view('maquinarias.edit', compact('maquinaria', 'pautas', 'pautasAsignadas'));
    }
    
    public function update(Request $request, Maquinaria $maquinaria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:camion,excavadora,cargador,otro',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'serie' => 'nullable|string|max:255|unique:maquinarias,serie,' . $maquinaria->id,
            'horometro_actual' => 'nullable|numeric|min:0',
            'estado' => 'nullable|in:activo,inactivo,mantencion',
            'fecha_compra' => 'nullable|date'
        ]);

        try {
            $datosAnteriores = $maquinaria->toArray();
            $horometroAnterior = $maquinaria->horometro_actual;
            
            $maquinaria->update([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'serie' => $request->serie ?? $maquinaria->serie,
                'horometro_actual' => $request->horometro_actual ?? $maquinaria->horometro_actual,
                'estado' => $request->estado ?? $maquinaria->estado,
                'fecha_compra' => $request->fecha_compra ?? $maquinaria->fecha_compra
            ]);

            // Registrar actividad
            $activityService = new ActivityLogService();
            
            // Si el horómetro cambió, registrar específicamente
            if ($horometroAnterior != $maquinaria->horometro_actual) {
                $activityService->logHorometroActualizado($maquinaria, $horometroAnterior);
            }
            
            // Registrar actualización general
            $activityService->logMaquinariaActualizada($maquinaria, $datosAnteriores);

            return response()->json([
                'success' => true,
                'message' => 'Maquinaria actualizada exitosamente',
                'data' => $maquinaria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la maquinaria: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function destroy(Request $request, Maquinaria $maquinaria)
    {
        $datosMaquinaria = $maquinaria->toArray();
        $maquinaria->delete();

        // Registrar actividad
        $activityService = new ActivityLogService();
        $activityService->logMaquinariaEliminada($datosMaquinaria);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Maquinaria eliminada exitosamente'
            ]);
        }

        return redirect()->route('admin.maquinarias.index')->with('success', 'Maquinaria eliminada exitosamente');
    }
    
    public function actualizarHorometro(Request $request, Maquinaria $maquinaria)
    {
        $request->validate([
            'horometro_actual' => 'required|numeric|min:'.$maquinaria->horometro_actual,
            'fecha_actualizacion' => 'required|date'
        ]);
        
        $incremento = $request->horometro_actual - $maquinaria->horometro_actual;
        
        $maquinaria->update([
            'horometro_actual' => $request->horometro_actual,
            'horometro_acumulado' => $maquinaria->horometro_acumulado + $incremento
        ]);
        
        // Verificar si hay mantenimientos pendientes
        $this->verificarMantenimientosPendientes($maquinaria);
        
        return back()->with('success', 'Horómetro actualizado exitosamente');
    }
    
    private function calcularProximosMantenimientos(Maquinaria $maquinaria)
    {
        $proximos = [];
        
        foreach ($maquinaria->pautas as $pauta) {
            $ultimaMantencion = $maquinaria->pautas->find($pauta->id)->pivot->ultima_mantencion_horas;
            $horasActuales = $maquinaria->horometro_actual;
            
            if ($pauta->tipo_equipo === 'camion') {
                $intervalos = [600, 1200, 1800, 2400, 3000];
            } else {
                $intervalos = [50, 250, 500, 1000];
            }
            
            foreach ($intervalos as $intervalo) {
                if ($horasActuales >= $ultimaMantencion + $intervalo * 0.8 && $horasActuales < $ultimaMantencion + $intervalo) {
                    $proximos[] = [
                        'pauta' => $pauta,
                        'intervalo' => $intervalo,
                        'horas_restantes' => $intervalo - ($horasActuales - $ultimaMantencion)
                    ];
                }
            }
        }
        
        return $proximos;
    }
    
    private function verificarMantenimientosPendientes(Maquinaria $maquinaria)
    {
        foreach ($maquinaria->pautas as $pauta) {
            $ultimaMantencion = $maquinaria->pautas->find($pauta->id)->pivot->ultima_mantencion_horas;
            $horasActuales = $maquinaria->horometro_actual;
            
            if ($pauta->tipo_equipo === 'camion') {
                $intervalos = [600, 1200, 1800, 2400, 3000];
            } else {
                $intervalos = [50, 250, 500, 1000];
            }
            
            foreach ($intervalos as $intervalo) {
                if ($horasActuales >= $ultimaMantencion + $intervalo) {
                    // Crear notificación u orden de trabajo
                    // Implementar según necesidades
                }
            }
        }
    }
}