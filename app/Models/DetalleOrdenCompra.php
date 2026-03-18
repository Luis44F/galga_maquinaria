<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden_compra';
    
    protected $fillable = [
        'orden_compra_id',
        'maquina_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'observaciones'
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    /**
     * Relación con la orden de compra
     */
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompraProveedor::class, 'orden_compra_id');
    }

    /**
     * Relación con la máquina
     */
    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }
}