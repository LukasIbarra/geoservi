<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PautaArea extends Model
{
    use HasFactory;
    protected $fillable = [
    'pauta_id',
    'nombre'
];

public function pauta()
{
    return $this->belongsTo(Pauta::class);
}

public function items()
{
    return $this->hasMany(PautaItem::class);
}
}
