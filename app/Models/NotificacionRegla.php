<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionRegla extends Model
{
    use HasFactory;

    protected $table = 'notificacion_reglas';

    protected $fillable = [
        'maquinaria_id',
        'tipo_notificacion',
        'horas_umbral',
        'canales',
        'activa'
    ];

    protected $casts = [
        'canales' => 'array',
        'activa' => 'boolean'
    ];

    /**
     * Relación con maquinaria
     */
    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class);
    }

    /**
     * Scope para reglas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope para reglas críticas
     */
    public function scopeCriticas($query)
    {
        return $query->where('tipo_notificacion', 'critica');
    }

    /**
     * Scope para reglas preventivas
     */
    public function scopePreventivas($query)
    {
        return $query->where('tipo_notificacion', 'preventiva');
    }
}
