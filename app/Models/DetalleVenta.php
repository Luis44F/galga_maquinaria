<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';
    
    protected $fillable = [
        'venta_id',
        'maquina_id',
        'precio_venta',
        'observaciones'
    ];

    protected $casts = [
        'precio_venta' => 'decimal:2'
    ];

    // Relación inversa: Pertenece a una venta [citation:2][citation:3]
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    // Relación inversa: Pertenece a una máquina
    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }
}