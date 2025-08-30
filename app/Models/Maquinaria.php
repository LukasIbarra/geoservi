<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre',
    'tipo',
    'marca',
    'modelo',
    'serie',
    'horometro_actual',
    'horometro_acumulado',
    'fecha_compra',
    'estado'
];

public function pautas()
{
    return $this->belongsToMany(Pauta::class, 'maquinaria_pauta')
                ->withPivot('ultima_mantencion_horas', 'ultima_mantencion_fecha')
                ->withTimestamps();
}

public function ordenesTrabajo()
{
    return $this->hasMany(OrdenTrabajo::class);
}
}
