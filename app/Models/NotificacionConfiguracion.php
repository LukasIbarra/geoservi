<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionConfiguracion extends Model
{
    use HasFactory;

    protected $table = 'notificacion_configuracion';

    protected $fillable = [
        'usuario_id',
        'canal',
        'direccion',
        'horario_inicio',
        'horario_fin',
        'dias_semana',
        'tipos_permitidos',
        'activo'
    ];

    protected $casts = [
        'tipos_permitidos' => 'array',
        'activo' => 'boolean'
    ];

    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para configuraciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Verificar si el tipo de notificación está permitido
     */
    public function tipoPermitido($tipo)
    {
        if (empty($this->tipos_permitidos)) {
            return true; // Si no hay restricciones, permitir todos
        }
        
        return in_array($tipo, $this->tipos_permitidos);
    }

    /**
     * Verificar si está en horario permitido
     */
    public function enHorario($hora = null)
    {
        $hora = $hora ?: now()->format('H:i');
        return $hora >= $this->horario_inicio && $hora <= $this->horario_fin;
    }

    /**
     * Verificar si el día está permitido
     */
    public function diaPermitido($dia = null)
    {
        $dia = $dia ?: now()->format('N'); // 1=Lunes, 7=Domingo
        
        $diasMap = [
            1 => 'L', 2 => 'M', 3 => 'X', 4 => 'J', 
            5 => 'V', 6 => 'S', 7 => 'D'
        ];
        
        return str_contains($this->dias_semana, $diasMap[$dia]);
    }
}
