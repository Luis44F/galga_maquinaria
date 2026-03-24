<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $table = 'maquinas';
    
    protected $fillable = [
        'codigo_maquina',
        'modelo_id',
        'modelo', // Mantenemos para evitar conflictos de asignación masiva
        'numero_serie',
        'año_fabricacion',
        'estado',
        'ubicacion_actual',
        'precio_compra',
        'precio_venta',
        'fecha_ingreso',
        'fecha_venta',
        'observaciones',
        'activo',
        'orden_compra_proveedor_id',
        'origen_importacion_id',
        'marca',
        'proveedor'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_venta' => 'date',
        'activo' => 'boolean',
        'año_fabricacion' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2'
    ];

    /**
     * Relación con la orden de compra
     */
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompraProveedor::class, 'orden_compra_proveedor_id');
    }

    /**
     * Relación con el modelo de máquina (maquinas_modelos)
     */
    public function modelo()
    {
        // Usamos withDefault para evitar errores de objeto nulo en las vistas
        return $this->belongsTo(MaquinaModelo::class, 'modelo_id')->withDefault([
            'modelo' => 'Sin modelo definido',
            'marca' => 'Genérica',
            'categoria_id' => null
        ]);
    }

    /**
     * Relación con categoría a través del modelo maestro
     */
    public function categoria()
    {
        return $this->hasOneThrough(
            Categoria::class,
            MaquinaModelo::class,
            'id',             // Llave foránea en MaquinaModelo (maquinas_modelos.id)
            'id',             // Llave foránea en Categoria (categorias.id)
            'modelo_id',      // Llave local en Maquina
            'categoria_id'    // Llave local en MaquinaModelo
        );
    }

    /**
     * Relación con seguimientos de estado
     */
    public function seguimientosEstado()
    {
        return $this->hasMany(SeguimientoEstado::class, 'maquina_id');
    }

    /**
     * Scopes para filtrado rápido
     */
    public function scopeDisponibles($query)
    {
        return $query->whereIn('estado', ['disponible', 'en_bodega'])
                     ->where('activo', true);
    }

    public function scopeEnCamino($query)
    {
        return $query->whereIn('estado', ['en_transito', 'en_puerto', 'fabricacion', 'pendiente_despacho']);
    }

    /**
     * Accessors para presentación en Blade
     */
    public function getEstadoDisplayAttribute()
    {
        $estados = [
            'disponible' => '📦 Disponible',
            'en_bodega' => '🏭 En Bodega',
            'en_transito' => '🚢 En Tránsito',
            'en_puerto' => '⚓ En Puerto',
            'reparacion' => '🔧 En Reparación',
            'fabricacion' => '🏗️ En Fabricación',
            'pendiente_despacho' => '⏳ Pendiente Despacho',
            'cancelado' => '❌ Cancelado',
            'vendida' => '💰 Vendida'
        ];
                
        return $estados[$this->estado] ?? $this->estado;
    }

    public function getEstadoColorAttribute()
    {
        $colores = [
            'disponible' => 'success',
            'en_bodega' => 'info',
            'en_transito' => 'primary',
            'en_puerto' => 'warning',
            'reparacion' => 'danger',
            'fabricacion' => 'secondary',
            'pendiente_despacho' => 'warning',
            'cancelado' => 'secondary',
            'vendida' => 'info'
        ];
                
        return $colores[$this->estado] ?? 'secondary';
    }

    public function getPrecioVentaFormateadoAttribute()
    {
        return $this->precio_venta ? '$' . number_format($this->precio_venta, 0, ',', '.') : 'N/A';
    }

    public function getPrecioCompraFormateadoAttribute()
    {
        return $this->precio_compra ? '$' . number_format($this->precio_compra, 0, ',', '.') : 'N/A';
    }
}