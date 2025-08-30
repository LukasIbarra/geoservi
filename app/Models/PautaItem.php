<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PautaItem extends Model
{
    use HasFactory;
    protected $fillable = [
    'pauta_area_id',
    'descripcion',
    'tipo'
];

public function area()
{
    return $this->belongsTo(PautaArea::class, 'pauta_area_id');
}

public function resultados()
{
    return $this->hasMany(OrdenTrabajoItem::class, 'pauta_item_id');
}
}
