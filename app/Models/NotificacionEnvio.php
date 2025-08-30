<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionEnvio extends Model
{
    use HasFactory;

    protected $table = 'notificacion_envios';

    protected $fillable = [
        'maquinaria_id',
        'usuario_id',
        'tipo',
        'canal',
        'mensaje',
        'estado',
        'fecha_envio',
        'fecha_lectura',
        'intentos',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'fecha_envio' => 'datetime',
        'fecha_lectura' => 'datetime'
    ];

    /**
     * Relación con maquinaria
     */
    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class);
    }

    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para notificaciones pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para notificaciones críticas
     */
    public function scopeCriticas($query)
    {
        return $query->where('tipo', 'critica');
    }

    /**
     * Scope para notificaciones no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->whereNull('fecha_lectura');
    }

    /**
     * Marcar como leída
     */
    public function marcarComoLeida()
    {
        $this->update([
            'estado' => 'leido',
            'fecha_lectura' => now()
        ]);
    }

    /**
     * Verificar si es crítica
     */
    public function esCritica()
    {
        return $this->tipo === 'critica';
    }

    /**
     * Obtener icono según tipo
     */
    public function getIconoAttribute()
    {
        return [
            'critica' => 'fa-exclamation-triangle text-red-500',
            'preventiva' => 'fa-clock text-yellow-500',
            'informativa' => 'fa-info-circle text-blue-500'
        ][$this->tipo] ?? 'fa-bell';
    }

    /**
     * Obtener color según estado
     */
    public function getColorEstadoAttribute()
    {
        return [
            'pendiente' => 'bg-gray-100 text-gray-800',
            'enviado' => 'bg-green-100 text-green-800',
            'fallido' => 'bg-red-100 text-red-800',
            'leido' => 'bg-blue-100 text-blue-800'
        ][$this->estado] ?? 'bg-gray-100';
    }
}
