<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_accion',
        'entidad_tipo',
        'entidad_id',
        'descripcion',
        'descripcion_detallada',
        'datos_anteriores',
        'datos_nuevos',
        'icono',
        'color',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el usuario que realizó la acción
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la entidad relacionada polimórficamente
     */
    public function entidad()
    {
        return $this->morphTo('entidad', 'entidad_tipo', 'entidad_id');
    }

    /**
     * Crear log de actividad con datos predefinidos según el tipo
     */
    public static function logActivity($tipo, $entidad, $datosAnteriores = null, $datosNuevos = null)
    {
        $user = auth()->user();
        $descripcion = '';
        $icono = 'fa-info-circle';
        $color = 'text-gray-500';

        // Determinar descripción, icono y color según el tipo de acción
        switch ($tipo) {
            case 'crear_maquinaria':
                $descripcion = "Se creó nueva máquina: {$entidad->nombre}";
                $icono = 'fa-plus-circle';
                $color = 'text-green-500';
                break;
                
            case 'editar_maquinaria':
                $descripcion = "Se actualizó máquina: {$entidad->nombre}";
                $icono = 'fa-edit';
                $color = 'text-blue-500';
                break;
                
            case 'eliminar_maquinaria':
                $nombreMaquina = isset($datosAnteriores['nombre']) ? $datosAnteriores['nombre'] : 'N/A';
                $descripcion = "Se eliminó máquina: {$nombreMaquina}";
                $icono = 'fa-trash';
                $color = 'text-red-500';
                break;
                
            case 'crear_pauta':
                $descripcion = "Se creó nueva pauta: {$entidad->nombre}";
                $icono = 'fa-clipboard-list';
                $color = 'text-purple-500';
                break;
                
            case 'asignar_pauta':
                $maquinariaId = isset($datosNuevos['maquinaria_id']) ? $datosNuevos['maquinaria_id'] : 0;
                $maquinaria = Maquinaria::find($maquinariaId);
                $nombreMaquina = $maquinaria ? $maquinaria->nombre : 'N/A';
                $descripcion = "Se asignó pauta \"{$entidad->nombre}\" a máquina \"{$nombreMaquina}\"";
                $icono = 'fa-link';
                $color = 'text-indigo-500';
                break;
                
            case 'crear_orden':
                $nombreMaquina = $entidad->maquinaria ? $entidad->maquinaria->nombre : 'N/A';
                $descripcion = "Se creó orden de trabajo #{$entidad->id} para {$nombreMaquina}";
                $icono = 'fa-wrench';
                $color = 'text-orange-500';
                break;
                
            case 'iniciar_orden':
                $descripcion = "Se inició orden de trabajo #{$entidad->id}";
                $icono = 'fa-play-circle';
                $color = 'text-yellow-500';
                break;
                
            case 'completar_orden':
                $descripcion = "Se completó orden de trabajo #{$entidad->id}";
                $icono = 'fa-check-circle';
                $color = 'text-green-500';
                break;
                
            case 'actualizar_horometro':
                $horasActuales = isset($datosNuevos['horometro_actual']) ? $datosNuevos['horometro_actual'] : 0;
                $descripcion = "Se actualizó horómetro de {$entidad->nombre}: {$horasActuales} hrs";
                $icono = 'fa-tachometer-alt';
                $color = 'text-cyan-500';
                break;
                
            case 'alerta_critica':
                $descripcion = "Alerta crítica: {$entidad->nombre} requiere mantenimiento urgente";
                $icono = 'fa-exclamation-triangle';
                $color = 'text-red-500 animate-pulse';
                break;
                
            case 'login':
                $descripcion = "Usuario {$user->name} inició sesión";
                $icono = 'fa-sign-in-alt';
                $color = 'text-gray-500';
                break;
                
            case 'logout':
                $descripcion = "Usuario {$user->name} cerró sesión";
                $icono = 'fa-sign-out-alt';
                $color = 'text-gray-500';
                break;
                
            default:
                $descripcion = "Acción: {$tipo}";
                break;
        }

        return self::create([
            'user_id' => $user ? $user->id : null,
            'tipo_accion' => $tipo,
            'entidad_tipo' => $entidad ? get_class($entidad) : null,
            'entidad_id' => $entidad ? $entidad->id : null,
            'descripcion' => $descripcion,
            'descripcion_detallada' => self::generarDescripcionDetallada($tipo, $entidad, $datosAnteriores, $datosNuevos),
            'datos_anteriores' => $datosAnteriores,
            'datos_nuevos' => $datosNuevos,
            'icono' => $icono,
            'color' => $color,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * Generar descripción detallada según el contexto
     */
    private static function generarDescripcionDetallada($tipo, $entidad, $datosAnteriores, $datosNuevos)
    {
        $detalles = [];
        
        if ($datosAnteriores && $datosNuevos) {
            // Comparar cambios
            foreach ($datosNuevos as $key => $value) {
                if (isset($datosAnteriores[$key]) && $datosAnteriores[$key] != $value) {
                    $detalles[] = ucfirst(str_replace('_', ' ', $key)) . ": {$datosAnteriores[$key]} → {$value}";
                }
            }
        }
        
        return !empty($detalles) ? implode(', ', $detalles) : null;
    }

    /**
     * Scope para obtener actividades recientes
     */
    public function scopeRecientes($query, $limit = 20)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope para filtrar por tipo de entidad
     */
    public function scopePorEntidad($query, $tipo, $id = null)
    {
        $query->where('entidad_tipo', $tipo);
        
        if ($id) {
            $query->where('entidad_id', $id);
        }
        
        return $query;
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('created_at', [$inicio, $fin]);
    }
}
