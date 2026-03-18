<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Maquinaria extends Model
{
    use HasFactory;

    protected $table = 'maquinas'; // IMPORTANTE: usamos la tabla 'maquinas'

    protected $fillable = [
        'codigo_interno',
        'nombre',
        'marca',
        'modelo',
        'serie',
        'tipo',
        'origen',
        'año_fabricacion',
        'estado',
        'precio_compra',
        'precio_venta',
        'ubicacion_bodega',
        'descripcion',
        'ficha_tecnica_pdf',
        'video_url',
        'orden_compra_proveedor_id'
    ];

    protected $casts = [
        'año_fabricacion' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Generar código automático al crear
    protected static function booted()
    {
        static::creating(function ($maquinaria) {
            // Si no tiene código interno, generarlo automáticamente
            if (empty($maquinaria->codigo_interno)) {
                $ultimo = static::query()
                            ->where('codigo_interno', 'like', 'GALGA-MAQ-%')
                            ->orderBy('codigo_interno', 'desc')
                            ->first();

                if ($ultimo) {
                    $ultimoNumero = intval(Str::after($ultimo->codigo_interno, 'GALGA-MAQ-'));
                    $nuevoNumero = str_pad($ultimoNumero + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $nuevoNumero = '0001';
                }

                $maquinaria->codigo_interno = 'GALGA-MAQ-' . $nuevoNumero;
            }
        });
    }

    // Relaciones
    public function imagenes()
    {
        return $this->hasMany(ImagenMaquinaria::class, 'maquinaria_id');
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ImagenMaquinaria::class, 'maquinaria_id')->where('es_principal', true);
    }

    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompraProveedor::class, 'orden_compra_proveedor_id');
    }

    // Scopes para filtros
    public function scopeDisponible($query)
    {
        return $query->where('estado', 'EN_INVENTARIO');
    }

    public function scopeEnCamino($query)
    {
        return $query->where('estado', 'EN_CAMINO');
    }

    public function scopeReservada($query)
    {
        return $query->where('estado', 'RESERVADA');
    }

    public function scopeVendida($query)
    {
        return $query->where('estado', 'VENDIDA');
    }

    public function scopeDeTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo', $tipo);
        }
        return $query;
    }

    public function scopeDeMarca($query, $marca)
    {
        if ($marca) {
            return $query->where('marca', $marca);
        }
        return $query;
    }

    public function scopePrecioEntre($query, $min, $max)
    {
        if ($min && $max) {
            return $query->whereBetween('precio_venta', [$min, $max]);
        }
        return $query;
    }

    // Accessors
    public function getEstadoDisplayAttribute()
    {
        return match($this->estado) {
            'EN_CAMINO' => '🚢 En Camino',
            'EN_INVENTARIO' => '📦 Disponible',
            'RESERVADA' => '🔒 Reservada',
            'VENDIDA' => '💰 Vendida',
            default => $this->estado
        };
    }

    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'EN_CAMINO' => 'info',
            'EN_INVENTARIO' => 'success',
            'RESERVADA' => 'warning',
            'VENDIDA' => 'secondary',
            default => 'secondary'
        };
    }

    public function getPrecioVentaFormateadoAttribute()
    {
        return '$' . number_format($this->precio_venta, 0, ',', '.');
    }

    public function getPrecioCompraFormateadoAttribute()
    {
        return $this->precio_compra ? '$' . number_format($this->precio_compra, 0, ',', '.') : 'N/A';
    }
}