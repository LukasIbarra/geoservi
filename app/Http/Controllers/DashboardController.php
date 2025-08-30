<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use App\Models\OrdenTrabajo;
use App\Models\User;
use App\Models\Pauta;
use App\Services\ActivityLogService;
use App\Services\PDFExportService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // === ESTADÍSTICAS GENERALES ===
        $totalMaquinarias = Maquinaria::count();
        $maquinariasActivas = Maquinaria::where('estado', 'activo')->count();
        $maquinariasInactivas = Maquinaria::where('estado', 'inactivo')->count();
        $maquinariasMantenimiento = Maquinaria::where('estado', 'mantenimiento')->count();
        
        // Usuarios del sistema
        $totalUsuarios = User::count();
        $tecnicosActivos = User::where('role', 'tecnico')->count();
        
        // === ÓRDENES DE TRABAJO ===
        $mantenimientosPendientes = OrdenTrabajo::where('estado', 'pendiente')->count();
        $mantenimientosEnProceso = OrdenTrabajo::where('estado', 'en_proceso')->count();
        $mantenimientosCompletadosHoy = OrdenTrabajo::where('estado', 'completado')
            ->whereDate('fecha_fin', Carbon::today())
            ->count();
        
        // Total de mantenimientos del mes
        $mantenimientosMes = OrdenTrabajo::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // === HORÓMETROS Y ALERTAS CRÍTICAS ===
        $maquinariasConHorometro = Maquinaria::with(['pautas'])
            ->where('estado', 'activo')
            ->get()
            ->map(function ($maquinaria) {
                $proximaMantencion = null;
                $horasRestantes = null;
                $porcentajeUso = 0;
                $estadoAlerta = 'normal'; // normal, warning, critical
                
                // Calcular próxima mantención basada en horómetro
                foreach ($maquinaria->pautas as $pauta) {
                    $ultimaMantencion = $pauta->pivot->ultima_mantencion_horas ?? 0;
                    $proximaHora = $ultimaMantencion + $pauta->frecuencia_horas;
                    $horasRestantesPauta = $proximaHora - $maquinaria->horometro_actual;
                    
                    if ($proximaMantencion === null || $horasRestantesPauta < $horasRestantes) {
                        $proximaMantencion = $pauta;
                        $horasRestantes = $horasRestantesPauta;
                    }
                }
                
                // Calcular porcentaje de uso hasta próxima mantención
                if ($proximaMantencion && $proximaMantencion->frecuencia_horas > 0) {
                    $horasUsadas = $maquinaria->horometro_actual - ($proximaMantencion->pivot->ultima_mantencion_horas ?? 0);
                    $porcentajeUso = min(100, ($horasUsadas / $proximaMantencion->frecuencia_horas) * 100);
                    
                    // Determinar estado de alerta
                    if ($porcentajeUso >= 95) {
                        $estadoAlerta = 'critical';
                    } elseif ($porcentajeUso >= 80) {
                        $estadoAlerta = 'warning';
                    }
                }
                
                return [
                    'id' => $maquinaria->id,
                    'nombre' => $maquinaria->nombre,
                    'tipo' => $maquinaria->tipo,
                    'horometro_actual' => $maquinaria->horometro_actual,
                    'proxima_pauta' => $proximaMantencion ? $proximaMantencion->nombre : 'Sin pauta',
                    'horas_restantes' => $horasRestantes ?? 0,
                    'porcentaje_uso' => round($porcentajeUso, 1),
                    'estado_alerta' => $estadoAlerta
                ];
            })
            ->sortBy('horas_restantes')
            ->take(10);
        
        // Máquinas críticas (menos de 50 horas para mantención)
        $maquinasCriticas = $maquinariasConHorometro->filter(function ($maq) {
            return $maq['horas_restantes'] <= 50 && $maq['horas_restantes'] > 0;
        })->count();
        
        // === DATOS PARA GRÁFICOS ===
        
        // Distribución de estados de maquinaria (para gráfico de torta)
        $distribucionEstados = [
            'Activas' => $maquinariasActivas,
            'En Mantenimiento' => $maquinariasMantenimiento,
            'Inactivas' => $maquinariasInactivas
        ];
        
        // Tendencia de mantenimientos últimos 6 meses (para gráfico de líneas)
        $tendenciaMantenimientos = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $count = OrdenTrabajo::whereMonth('created_at', $fecha->month)
                ->whereYear('created_at', $fecha->year)
                ->count();
            $tendenciaMantenimientos[] = [
                'mes' => $fecha->format('M'),
                'cantidad' => $count
            ];
        }
        
        // Mantenimientos por tipo de máquina (para gráfico de barras)
        $mantenimientosPorTipo = DB::table('ordenes_trabajo')
            ->join('maquinarias', 'ordenes_trabajo.maquinaria_id', '=', 'maquinarias.id')
            ->select('maquinarias.tipo', DB::raw('count(*) as total'))
            ->whereMonth('ordenes_trabajo.created_at', Carbon::now()->month)
            ->groupBy('maquinarias.tipo')
            ->get();
        
        // === ACTIVIDADES RECIENTES ===
        $activityLogService = new ActivityLogService();
        $actividadesRecientes = $activityLogService->obtenerActividadesRecientes(15);
        
        // === KPIs IMPORTANTES ===
        
        // Tasa de cumplimiento de mantenimientos (%)
        $mantenimientosCompletados = OrdenTrabajo::where('estado', 'completado')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $tasaCumplimiento = $mantenimientosMes > 0 
            ? round(($mantenimientosCompletados / $mantenimientosMes) * 100, 1) 
            : 0;
        
        // Disponibilidad promedio de maquinaria (%)
        $disponibilidad = $totalMaquinarias > 0 
            ? round(($maquinariasActivas / $totalMaquinarias) * 100, 1) 
            : 0;
        
        // Próximos mantenimientos programados
        $proximosMantenimientos = OrdenTrabajo::with(['maquinaria', 'pauta'])
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get()
            ->map(function ($orden) {
                // Calcular horas restantes basado en el horómetro actual
                $horasRestantes = 0;
                if ($orden->maquinaria && $orden->pauta) {
                    $ultimaMantencion = DB::table('maquinaria_pauta')
                        ->where('maquinaria_id', $orden->maquinaria_id)
                        ->where('pauta_id', $orden->pauta_id)
                        ->first();
                    
                    if ($ultimaMantencion) {
                        $proximaHora = ($ultimaMantencion->ultima_mantencion_horas ?? 0) + $orden->pauta->frecuencia_horas;
                        $horasRestantes = max(0, $proximaHora - $orden->maquinaria->horometro_actual);
                    }
                }
                
                $orden->horas_restantes = $horasRestantes;
                return $orden;
            });
        
        return view('admin.dashboard', compact(
            'totalMaquinarias',
            'maquinariasActivas',
            'maquinariasInactivas',
            'maquinariasMantenimiento',
            'totalUsuarios',
            'tecnicosActivos',
            'mantenimientosPendientes',
            'mantenimientosEnProceso',
            'mantenimientosCompletadosHoy',
            'mantenimientosMes',
            'maquinariasConHorometro',
            'maquinasCriticas',
            'distribucionEstados',
            'tendenciaMantenimientos',
            'mantenimientosPorTipo',
            'actividadesRecientes',
            'tasaCumplimiento',
            'disponibilidad',
            'proximosMantenimientos'
        ));
    }

    /**
     * Exportar dashboard a PDF
     */
    public function exportarPDF(Request $request)
    {
        $pdfService = new PDFExportService();
        
        // Recopilar todos los datos del dashboard
        $datos = $this->obtenerDatosDashboard();
        
        $pdf = $pdfService->generarDashboardPDF($datos);
        
        return $pdf->download('dashboard_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Obtener datos del dashboard para exportación
     */
    private function obtenerDatosDashboard()
    {
        // Reutilizar la lógica del método index
        $totalMaquinarias = Maquinaria::count();
        $maquinariasActivas = Maquinaria::where('estado', 'activo')->count();
        $maquinariasInactivas = Maquinaria::where('estado', 'inactivo')->count();
        $maquinariasMantenimiento = Maquinaria::where('estado', 'mantenimiento')->count();
        
        $totalUsuarios = User::count();
        $tecnicosActivos = User::where('role', 'tecnico')->count();
        
        $mantenimientosPendientes = OrdenTrabajo::where('estado', 'pendiente')->count();
        $mantenimientosEnProceso = OrdenTrabajo::where('estado', 'en_proceso')->count();
        $mantenimientosCompletadosHoy = OrdenTrabajo::where('estado', 'completado')
            ->whereDate('fecha_fin', Carbon::today())
            ->count();
        
        $mantenimientosMes = OrdenTrabajo::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $mantenimientosCompletados = OrdenTrabajo::where('estado', 'completado')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        
        $tasaCumplimiento = $mantenimientosMes > 0 
            ? round(($mantenimientosCompletados / $mantenimientosMes) * 100, 1) 
            : 0;
        
        $disponibilidad = $totalMaquinarias > 0 
            ? round(($maquinariasActivas / $totalMaquinarias) * 100, 1) 
            : 0;
        
        return compact(
            'totalMaquinarias',
            'maquinariasActivas',
            'maquinariasInactivas',
            'maquinariasMantenimiento',
            'totalUsuarios',
            'tecnicosActivos',
            'mantenimientosPendientes',
            'mantenimientosEnProceso',
            'mantenimientosCompletadosHoy',
            'mantenimientosMes',
            'tasaCumplimiento',
            'disponibilidad'
        );
    }
}


    
