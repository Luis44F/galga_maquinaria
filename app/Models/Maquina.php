<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $table = 'maquinas';
    
    protected $fillable = [
        'modelo_id',
        'orden_compra_proveedor_id', // Relación con la orden de compra
        'numero_serie',
        'año_fabricacion',
        'estado',
        'precio_compra',
        'precio_venta',
        'fecha_ingreso',
        'observaciones'
    ];

    protected $casts = [
        'año_fabricacion' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'fecha_ingreso' => 'date'
    ];

    /**
     * Relación con la orden de compra del proveedor
     */
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompraProveedor::class, 'orden_compra_proveedor_id');
    }

    /**
     * Relación con el modelo de máquina
     */
    public function modelo()
    {
        return $this->belongsTo(MaquinaModelo::class, 'modelo_id')->withDefault([
            'modelo' => 'Sin modelo',
            'marca' => 'Sin marca',
            'categoria_id' => null
        ]);
    }

    /**
     * Relación con categoría a través del modelo
     */
    public function categoria()
    {
        return $this->hasOneThrough(
            Categoria::class,
            MaquinaModelo::class,
            'id', 
            'id', 
            'modelo_id', 
            'categoria_id' 
        );
    }

    /**
     * Relación con seguimientos de estado
     */
    public function seguimientosEstado()
    {
        return $this->hasMany(SeguimientoEstado::class, 'maquina_id');
    }

    // =========================================================================
    // SCOPES (Lógica de filtrado)
    // =========================================================================

    public function scopeDisponible($query)
    {
        return $query->whereIn('estado', ['disponible', 'en_bodega']);
    }

    public function scopeEnCamino($query)
    {
        return $query->whereIn('estado', ['en_transito', 'en_puerto', 'orden_pendiente', 'en_fabricacion']);
    }

    public function scopeReservada($query)
    {
        return $query->where('estado', 'con_anticipo');
    }

    public function scopeVendida($query)
    {
        return $query->where('estado', 'vendida');
    }

    // =========================================================================
    // ACCESSORS (Formatos para la Vista)
    // =========================================================================

    public function getPrecioVentaFormateadoAttribute()
    {
        return '$' . number_format($this->precio_venta, 0, ',', '.');
    }

    public function getPrecioCompraFormateadoAttribute()
    {
        return $this->precio_compra ? '$' . number_format($this->precio_compra, 0, ',', '.') : 'N/A';
    }

    public function getEstadoDisplayAttribute()
    {
        $estados = [
            'disponible' => '📦 Disponible',
            'en_bodega' => '🏭 En Bodega',
            'en_transito' => '🚢 En Tránsito',
            'en_puerto' => '⚓ En Puerto',
            'orden_pendiente' => '📋 Orden Pendiente',
            'con_anticipo' => '🔒 Reservada',
            'en_fabricacion' => '🏗️ En Fabricación',
            'vendida' => '💰 Vendida'
        ];
        
        return $estados[$this->estado] ?? $this->estado;
    }
}