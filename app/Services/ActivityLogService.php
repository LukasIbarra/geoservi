<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Maquinaria;
use App\Models\Pauta;
use App\Models\OrdenTrabajo;
use Illuminate\Support\Facades\Log;

class ActivityLogService
{
    /**
     * Registrar creación de maquinaria
     */
    public function logMaquinariaCreada(Maquinaria $maquinaria)
    {
        try {
            ActivityLog::logActivity('crear_maquinaria', $maquinaria, null, $maquinaria->toArray());
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar actualización de maquinaria
     */
    public function logMaquinariaActualizada(Maquinaria $maquinaria, array $datosAnteriores)
    {
        try {
            ActivityLog::logActivity('editar_maquinaria', $maquinaria, $datosAnteriores, $maquinaria->toArray());
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar eliminación de maquinaria
     */
    public function logMaquinariaEliminada(array $datosMaquinaria)
    {
        try {
            ActivityLog::logActivity('eliminar_maquinaria', null, $datosMaquinaria, null);
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar creación de pauta
     */
    public function logPautaCreada(Pauta $pauta)
    {
        try {
            ActivityLog::logActivity('crear_pauta', $pauta, null, $pauta->toArray());
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar asignación de pauta a maquinaria
     */
    public function logPautaAsignada(Pauta $pauta, Maquinaria $maquinaria)
    {
        try {
            ActivityLog::logActivity('asignar_pauta', $pauta, null, [
                'maquinaria_id' => $maquinaria->id,
                'maquinaria_nombre' => $maquinaria->nombre,
                'pauta_id' => $pauta->id,
                'pauta_nombre' => $pauta->nombre
            ]);
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar creación de orden de trabajo
     */
    public function logOrdenCreada(OrdenTrabajo $orden)
    {
        try {
            $orden->load(['maquinaria', 'pauta', 'tecnico']);
            ActivityLog::logActivity('crear_orden', $orden, null, [
                'orden_id' => $orden->id,
                'maquinaria' => $orden->maquinaria ? $orden->maquinaria->nombre : 'N/A',
                'pauta' => $orden->pauta ? $orden->pauta->nombre : 'N/A',
                'tecnico' => $orden->tecnico ? $orden->tecnico->name : 'Sin asignar'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar inicio de orden de trabajo
     */
    public function logOrdenIniciada(OrdenTrabajo $orden)
    {
        try {
            $orden->load(['maquinaria', 'tecnico']);
            ActivityLog::logActivity('iniciar_orden', $orden, 
                ['estado' => 'pendiente'], 
                ['estado' => 'en_proceso', 'tecnico' => $orden->tecnico ? $orden->tecnico->name : 'N/A']
            );
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar finalización de orden de trabajo
     */
    public function logOrdenCompletada(OrdenTrabajo $orden)
    {
        try {
            $orden->load(['maquinaria', 'tecnico']);
        $fechaInicio = \Carbon\Carbon::parse($orden->fecha_inicio);
        $fechaFin = \Carbon\Carbon::parse($orden->fecha_fin);
        
        ActivityLog::logActivity('completar_orden', $orden, 
                ['estado' => $orden->getOriginal('estado')], 
                [
                    'estado' => 'completado',
                    'duracion_horas' => $fechaInicio && $fechaFin ? 
                        $fechaInicio->diffInHours($fechaFin) : 0
                ]
            );
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar actualización de horómetro
     */
    public function logHorometroActualizado(Maquinaria $maquinaria, $horometroAnterior)
    {
        try {
            ActivityLog::logActivity('actualizar_horometro', $maquinaria, 
                ['horometro_actual' => $horometroAnterior], 
                ['horometro_actual' => $maquinaria->horometro_actual]
            );
        } catch (\Exception $e) {
            Log::error('Error al registrar actividad: ' . $e->getMessage());
        }
    }

    /**
     * Registrar alerta crítica
     */
    public function logAlertaCritica(Maquinaria $maquinaria, $mensaje)
    {
        try {
            ActivityLog::create([
                'user_id' => null, // Sistema automático
                'tipo_accion' => 'alerta_critica',
                'entidad_tipo' => get_class($maquinaria),
                'entidad_id' => $maquinaria->id,
                'descripcion' => $mensaje,
                'descripcion_detallada' => "Horómetro actual: {$maquinaria->horometro_actual} hrs",
                'icono' => 'fa-exclamation-triangle',
                'color' => 'text-red-500 animate-pulse',
                'ip_address' => request()->ip(),
                'user_agent' => 'Sistema Automático'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al registrar alerta crítica: ' . $e->getMessage());
        }
    }

    /**
     * Obtener actividades recientes formateadas para el dashboard
     */
    public function obtenerActividadesRecientes($limite = 20)
    {
        return ActivityLog::with('user')
            ->recientes($limite)
            ->get()
            ->map(function ($actividad) {
                return [
                    'id' => $actividad->id,
                    'icon' => $actividad->icono,
                    'color' => $actividad->color,
                    'mensaje' => $actividad->descripcion,
                    'detalles' => $actividad->descripcion_detallada,
                    'tecnico' => $actividad->user ? $actividad->user->name : 'Sistema',
                    'tiempo' => $actividad->created_at->diffForHumans(),
                    'fecha' => $actividad->created_at->format('d/m/Y H:i'),
                    'tipo' => $actividad->tipo_accion,
                    'entidad_tipo' => class_basename($actividad->entidad_tipo),
                    'entidad_id' => $actividad->entidad_id,
                    'pauta' => null // Para mantener compatibilidad con el dashboard actual
                ];
            });
    }

    /**
     * Obtener estadísticas de actividades
     */
    public function obtenerEstadisticasActividades($dias = 30)
    {
        $fechaInicio = now()->subDays($dias);
        
        $actividades = ActivityLog::where('created_at', '>=', $fechaInicio)
            ->select('tipo_accion', \DB::raw('count(*) as total'))
            ->groupBy('tipo_accion')
            ->get();
        
        return [
            'total' => $actividades->sum('total'),
            'por_tipo' => $actividades->pluck('total', 'tipo_accion')->toArray(),
            'promedio_diario' => round($actividades->sum('total') / $dias, 1)
        ];
    }
}
