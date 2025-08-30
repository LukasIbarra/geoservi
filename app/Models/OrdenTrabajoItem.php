<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoItem extends Model
{
    use HasFactory;
    
    protected $table = 'orden_trabajo_items';
    
    protected $fillable = [
        'orden_id',
        'pauta_item_id',
        'cumplido',
        'comentario'
    ];

    protected $casts = [
        'cumplido' => 'boolean',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_id');
    }

    public function item()
    {
        return $this->belongsTo(PautaItem::class, 'pauta_item_id');
    }
}
