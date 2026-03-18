<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    
    protected $fillable = [
        'numero_venta',
        'cliente_id',
        'vendedor_id',
        'fecha_venta',
        'precio_total',
        'anticipo',
        'saldo_pendiente',
        'estado_pago',
        'estado_despacho',
        'observaciones'
    ];

    protected $casts = [
        'fecha_venta' => 'date',
        'precio_total' => 'decimal:2',
        'anticipo' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2'
    ];

    // Relación inversa: Pertenece a un cliente [citation:2][citation:3]
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación inversa: Pertenece a un vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor_id');
    }

    // Relación: Una venta tiene muchos detalles [citation:1][citation:2]
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    // Relación: Una venta tiene muchos anticipos [citation:1][citation:2]
    public function anticipos()
    {
        return $this->hasMany(Anticipo::class, 'venta_id');
    }

    // Relación: Una venta puede tener un despacho [citation:1][citation:2]
    public function despacho()
    {
        return $this->hasOne(Despacho::class, 'venta_id');
    }

    // Relación: Una venta puede tener un crédito en estudio
    public function creditoEstudio()
    {
        return $this->hasOne(CreditoEstudio::class, 'venta_id');
    }
}