<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    // app/Models/Notificacion.php
protected $fillable = [
    'titulo',
    'mensaje',
    'tipo',
    'usuario_id',
    'leido'
];

public function usuario()
{
    return $this->belongsTo(User::class);
}
}
