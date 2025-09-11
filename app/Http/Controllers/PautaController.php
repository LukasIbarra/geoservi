<?php

namespace App\Http\Controllers;

use App\Models\Pauta;
use Illuminate\Http\Request;

class PautaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/pautas');
    }

    public function datatable(Request $request)
    {
        // Base query
        $base = Pauta::query();
        $recordsTotal = $base->count();

        // Clone for filters
        $query = clone $base;

        // Búsqueda (soporta custom_search, objeto DataTables y string simple)
        $searchVal = null;
        if ($request->filled('custom_search')) {
            $searchVal = $request->input('custom_search');
        } elseif ($request->has('search')) {
            $searchVal = is_array($request->search) ? ($request->search['value'] ?? null) : $request->search;
        }
        if (!empty($searchVal)) {
            $query->where(function ($q) use ($searchVal) {
                $q->where('nombre', 'like', "%{$searchVal}%")
                  ->orWhere('descripcion', 'like', "%{$searchVal}%");
            });
        }

        // Filtro por tipo de equipo
        if ($request->filled('tipoFilter')) {
            $query->where('tipo_equipo', $request->input('tipoFilter'));
        }

        // Filtro por rango de fechas
        if ($request->filled('fechaDesde')) {
            $query->whereDate('created_at', '>=', $request->input('fechaDesde'));
        }
        if ($request->filled('fechaHasta')) {
            $query->whereDate('created_at', '<=', $request->input('fechaHasta'));
        }

        // Orden
        $allowed = ['id','nombre','tipo_equipo','frecuencia_horas','frecuencia_dias','created_at'];
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
        $pautas = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $pautas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_equipo' => 'required|in:camion,maquinaria,ambos',
            'descripcion' => 'nullable|string',
            'frecuencia_horas' => 'nullable|numeric|min:0',
            'frecuencia_dias' => 'nullable|integer|min:0',
        ]);

        $pauta = Pauta::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pauta creada exitosamente',
            'data' => $pauta
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pauta $pauta)
    {
        $pauta->load(['areas.items']);
        return view('admin/pautas_show', compact('pauta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pauta $pauta)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_equipo' => 'required|in:camion,maquinaria,ambos',
            'descripcion' => 'nullable|string',
            'frecuencia_horas' => 'nullable|numeric|min:0',
            'frecuencia_dias' => 'nullable|integer|min:0',
        ]);

        $pauta->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pauta actualizada exitosamente',
            'data' => $pauta
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pauta $pauta)
    {
        $pauta->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pauta eliminada exitosamente'
            ]);
        }

        return redirect()->route('admin.pautas.index')->with('success', 'Pauta eliminada exitosamente');
    }

    // ================== ÁREAS DE PAUTA ==================
    public function storeArea(Request $request, Pauta $pauta)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $area = $pauta->areas()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Área creada exitosamente',
            'data' => $area
        ], 201);
    }

    public function updateArea(Request $request, \App\Models\PautaArea $area)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $area->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Área actualizada exitosamente',
            'data' => $area
        ]);
    }

    public function destroyArea(Request $request, \App\Models\PautaArea $area)
    {
        $area->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Área eliminada exitosamente'
            ]);
        }

        return back()->with('success', 'Área eliminada exitosamente');
    }

    // ================== ÍTEMS DE ÁREA ==================
    public function storeItem(Request $request, \App\Models\PautaArea $area)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
            'tipo' => 'required|string|max:50'
        ]);

        $item = $area->items()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ítem creado exitosamente',
            'data' => $item
        ], 201);
    }

    public function updateItem(Request $request, \App\Models\PautaItem $item)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
            'tipo' => 'required|string|max:50'
        ]);

        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ítem actualizado exitosamente',
            'data' => $item
        ]);
    }

    public function destroyItem(Request $request, \App\Models\PautaItem $item)
    {
        $item->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ítem eliminado exitosamente'
            ]);
        }

        return back()->with('success', 'Ítem eliminado exitosamente');
    }
}
