<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedores';
    
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    // Relación: Un vendedor tiene muchas órdenes de compra [citation:1][citation:2]
    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompraProveedor::class, 'created_by');
    }

    // Relación: Un vendedor tiene muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    // Relación: Un vendedor registra muchos anticipos
    public function anticiposRegistrados()
    {
        return $this->hasMany(Anticipo::class, 'registrado_por');
    }

    // Relación: Un vendedor registra muchos seguimientos de estado
    public function seguimientosEstado()
    {
        return $this->hasMany(SeguimientoEstado::class, 'usuario_cambio');
    }
}