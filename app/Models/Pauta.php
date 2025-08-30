<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pauta extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre',
    'tipo_equipo',
    'descripcion',
    'frecuencia_horas',
    'frecuencia_dias'
];

public function areas()
{
    return $this->hasMany(PautaArea::class);
}

public function maquinarias()
{
    return $this->belongsToMany(Maquinaria::class, 'maquinaria_pauta')
                ->withPivot('ultima_mantencion_horas', 'ultima_mantencion_fecha')
                ->withTimestamps();
}

public function ordenesTrabajo()
{
    return $this->hasMany(OrdenTrabajo::class);
}
}
