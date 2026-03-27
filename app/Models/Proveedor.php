<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'codigo',
        'nombre',
        'razon_social',
        'nit',
        'pais',
        'ciudad',
        'direccion',
        'telefono',
        'email',
        'contacto_nombre',
        'contacto_telefono',
        'contacto_email',
        'tipo',
        'observaciones',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    /**
     * Relación con órdenes de compra
     * NOTA: La tabla ordenes_compra_proveedor tiene el campo 'proveedor' (nombre) no 'proveedor_id'
     */
    public function ordenesCompra()
    {
        // La relación se hace por el campo 'proveedor' que almacena el nombre
        return $this->hasMany(OrdenCompraProveedor::class, 'proveedor', 'nombre');
    }

    /**
     * Get tipo display with icon
     */
    public function getTipoDisplayAttribute()
    {
        return $this->tipo == 'nacional' ? '🇨🇴 Nacional' : '🌎 Internacional';
    }

    /**
     * Get tipo color for badge
     */
    public function getTipoColorAttribute()
    {
        return $this->tipo == 'nacional' ? 'success' : 'primary';
    }

    /**
     * Get estado display
     */
    public function getEstadoDisplayAttribute()
    {
        return $this->activo ? '✅ Activo' : '❌ Inactivo';
    }

    /**
     * Get estado color
     */
    public function getEstadoColorAttribute()
    {
        return $this->activo ? 'success' : 'secondary';
    }
}