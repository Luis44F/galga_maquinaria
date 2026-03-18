<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despacho extends Model
{
    use HasFactory;

    protected $table = 'despachos';
    
    protected $fillable = [
        'venta_id',
        'guia_despacho',
        'transportista',
        'fecha_despacho',
        'fecha_estimada_entrega',
        'fecha_entrega_real',
        'estado',
        'direccion_entrega',
        'recibido_por',
        'observaciones'
    ];

    protected $casts = [
        'fecha_despacho' => 'date',
        'fecha_estimada_entrega' => 'date',
        'fecha_entrega_real' => 'date'
    ];

    // Relación inversa: Pertenece a una venta [citation:2][citation:3]
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}