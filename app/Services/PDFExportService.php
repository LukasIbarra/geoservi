<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Maquinaria;
use App\Models\OrdenTrabajo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PDFExportService
{
    /**
     * Generar PDF del dashboard completo
     */
    public function generarDashboardPDF($datos = null)
    {
        if (!$datos) {
            $datos = $this->obtenerDatosDashboard();
        }

        $pdf = PDF::loadView('pdf.dashboard', $datos);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generar PDF de reporte de mantenimientos
     */
    public function generarReporteMantenimientos($fechaInicio, $fechaFin)
    {
        $mantenimientos = OrdenTrabajo::with(['maquinaria', 'pauta', 'tecnico'])
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('created_at', 'desc')
            ->get();

        $estadisticas = [
            'total' => $mantenimientos->count(),
            'completados' => $mantenimientos->where('estado', 'completado')->count(),
            'pendientes' => $mantenimientos->where('estado', 'pendiente')->count(),
            'en_proceso' => $mantenimientos->where('estado', 'en_proceso')->count(),
        ];

        $datos = [
            'titulo' => 'Reporte de Mantenimientos',
            'periodo' => Carbon::parse($fechaInicio)->format('d/m/Y') . ' - ' . Carbon::parse($fechaFin)->format('d/m/Y'),
            'mantenimientos' => $mantenimientos,
            'estadisticas' => $estadisticas,
            'fecha_generacion' => now()->format('d/m/Y H:i')
        ];

        $pdf = PDF::loadView('pdf.reporte-mantenimientos', $datos);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }

    /**
     * Generar PDF de estado de maquinarias
     */
    public function generarEstadoMaquinarias()
    {
        $maquinarias = Maquinaria::with(['pautas', 'ordenesTrabajo' => function($query) {
            $query->latest()->limit(5);
        }])->get();

        $estadisticas = [
            'total' => $maquinarias->count(),
            'activas' => $maquinarias->where('estado', 'activo')->count(),
            'mantenimiento' => $maquinarias->where('estado', 'mantenimiento')->count(),
            'inactivas' => $maquinarias->where('estado', 'inactivo')->count(),
        ];

        $datos = [
            'titulo' => 'Estado de Maquinarias',
            'maquinarias' => $maquinarias,
            'estadisticas' => $estadisticas,
            'fecha_generacion' => now()->format('d/m/Y H:i')
        ];

        $pdf = PDF::loadView('pdf.estado-maquinarias', $datos);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generar PDF de análisis de horómetros
     */
    public function generarAnalisisHorometros()
    {
        $maquinarias = Maquinaria::with('pautas')
            ->where('estado', 'activo')
            ->get()
            ->map(function ($maquinaria) {
                $proximaMantencion = null;
                $horasRestantes = null;
                
                foreach ($maquinaria->pautas as $pauta) {
                    $ultimaMantencion = $pauta->pivot->ultima_mantencion_horas ?? 0;
                    $proximaHora = $ultimaMantencion + $pauta->frecuencia_horas;
                    $horasRestantesPauta = $proximaHora - $maquinaria->horometro_actual;
                    
                    if ($proximaMantencion === null || $horasRestantesPauta < $horasRestantes) {
                        $proximaMantencion = $pauta;
                        $horasRestantes = $horasRestantesPauta;
                    }
                }
                
                return [
                    'maquinaria' => $maquinaria,
                    'proxima_pauta' => $proximaMantencion,
                    'horas_restantes' => $horasRestantes ?? 0,
                    'estado_critico' => ($horasRestantes ?? 0) <= 50
                ];
            })
            ->sortBy('horas_restantes');

        $datos = [
            'titulo' => 'Análisis de Horómetros',
            'maquinarias' => $maquinarias,
            'fecha_generacion' => now()->format('d/m/Y H:i'),
            'criticas' => $maquinarias->where('estado_critico', true)->count(),
            'total' => $maquinarias->count()
        ];

        $pdf = PDF::loadView('pdf.analisis-horometros', $datos);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }

    /**
     * Obtener datos del dashboard para exportación
     */
    private function obtenerDatosDashboard()
    {
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
        
        // Horómetros críticos
        $maquinariasConHorometro = Maquinaria::with(['pautas'])
            ->where('estado', 'activo')
            ->get()
            ->map(function ($maquinaria) {
                $proximaMantencion = null;
                $horasRestantes = null;
                $porcentajeUso = 0;
                
                foreach ($maquinaria->pautas as $pauta) {
                    $ultimaMantencion = $pauta->pivot->ultima_mantencion_horas ?? 0;
                    $proximaHora = $ultimaMantencion + $pauta->frecuencia_horas;
                    $horasRestantesPauta = $proximaHora - $maquinaria->horometro_actual;
                    
                    if ($proximaMantencion === null || $horasRestantesPauta < $horasRestantes) {
                        $proximaMantencion = $pauta;
                        $horasRestantes = $horasRestantesPauta;
                    }
                }
                
                if ($proximaMantencion && $proximaMantencion->frecuencia_horas > 0) {
                    $horasUsadas = $maquinaria->horometro_actual - ($proximaMantencion->pivot->ultima_mantencion_horas ?? 0);
                    $porcentajeUso = min(100, ($horasUsadas / $proximaMantencion->frecuencia_horas) * 100);
                }
                
                return [
                    'nombre' => $maquinaria->nombre,
                    'tipo' => $maquinaria->tipo,
                    'horometro_actual' => $maquinaria->horometro_actual,
                    'proxima_pauta' => $proximaMantencion ? $proximaMantencion->nombre : 'Sin pauta',
                    'horas_restantes' => $horasRestantes ?? 0,
                    'porcentaje_uso' => round($porcentajeUso, 1)
                ];
            })
            ->sortBy('horas_restantes')
            ->take(10);
        
        $maquinasCriticas = $maquinariasConHorometro->filter(function ($maq) {
            return $maq['horas_restantes'] <= 50 && $maq['horas_restantes'] > 0;
        })->count();
        
        // Tendencia de mantenimientos
        $tendenciaMantenimientos = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $count = OrdenTrabajo::whereMonth('created_at', $fecha->month)
                ->whereYear('created_at', $fecha->year)
                ->count();
            $tendenciaMantenimientos[] = [
                'mes' => $fecha->format('M Y'),
                'cantidad' => $count
            ];
        }
        
        $mantenimientosCompletados = OrdenTrabajo::where('estado', 'completado')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        
        $tasaCumplimiento = $mantenimientosMes > 0 
            ? round(($mantenimientosCompletados / $mantenimientosMes) * 100, 1) 
            : 0;
        
        $disponibilidad = $totalMaquinarias > 0 
            ? round(($maquinariasActivas / $totalMaquinarias) * 100, 1) 
            : 0;
        
        $fecha_generacion = now()->format('d/m/Y H:i');
        
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
            'maquinariasConHorometro',
            'maquinasCriticas',
            'tendenciaMantenimientos',
            'tasaCumplimiento',
            'disponibilidad',
            'fecha_generacion'
        );
    }
}
