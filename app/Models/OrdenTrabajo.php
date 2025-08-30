<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    use HasFactory;
protected $table = 'ordenes_trabajo';

protected $fillable = [
    'maquinaria_id',
    'pauta_id',
    'tecnico_id',
    'fecha_inicio',
    'fecha_fin',
    'horometro_en_ejecucion',
    'estado',
    'observaciones'
];

public function maquinaria()
{
    return $this->belongsTo(Maquinaria::class);
}

public function pauta()
{
    return $this->belongsTo(Pauta::class);
}

public function tecnico()
{
    return $this->belongsTo(User::class, 'tecnico_id');
}

public function items()
{
    return $this->hasMany(OrdenTrabajoItem::class, 'orden_id');
}
}
