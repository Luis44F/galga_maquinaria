<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraProveedor extends Model
{
    use HasFactory;

    protected $table = 'ordenes_compra_proveedor';
    
    protected $fillable = [
        'numero_orden',
        'proveedor_id',
        'proveedor',
        'pais_origen',
        'puerto_salida',
        'puerto_llegada',
        'fecha_orden',
        'fecha_salida',
        'fecha_estimada_llegada',
        'fecha_llegada_real',
        'estado',
        'observaciones',
        'created_by',
        'modelo_maquina',
        'cantidad_maquinas'
    ];

    protected $casts = [
        'fecha_orden' => 'date',
        'fecha_salida' => 'date',
        'fecha_estimada_llegada' => 'date',
        'fecha_llegada_real' => 'date'
    ];

    /**
     * ❌ DESACTIVADO: Usar número de orden en las rutas
     * Ahora se usará el ID por defecto
     */
    // public function getRouteKeyName()
    // {
    //     return 'numero_orden';
    // }

    /**
     * Relación con el proveedor
     */
    public function proveedorRelacion()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Relación con el usuario que creó la orden
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con los detalles de la orden
     */
    public function detalles()
    {
        return $this->hasMany(DetalleOrdenCompra::class, 'orden_compra_id');
    }

    /**
     * Relación con máquinas vinculadas a esta importación
     */
    public function maquinas()
    {
        return $this->hasMany(Maquina::class, 'orden_compra_proveedor_id');
    }

    // ==================== SCOPES ====================

    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    public function scopeActivas($query)
    {
        return $query->whereIn('estado', ['pendiente', 'en_fabricacion', 'en_transito', 'en_puerto']);
    }

    // ==================== ACCESSORS ====================

    public function getEstadoDisplayAttribute()
    {
        $estados = [
            'pendiente'      => '📋 Pendiente',
            'en_fabricacion' => '🏗️ En Fabricación',
            'en_transito'    => '🚢 En Tránsito',
            'en_puerto'      => '⚓ En Puerto',
            'recibida'       => '📦 Recibida',
            'cancelada'      => '❌ Cancelada'
        ];
                
        return $estados[$this->estado] ?? $this->estado;
    }

    public function getEstadoColorAttribute()
    {
        $colores = [
            'pendiente'      => 'warning',
            'en_fabricacion' => 'info',
            'en_transito'    => 'primary',
            'en_puerto'      => 'info',
            'recibida'       => 'success',
            'cancelada'      => 'secondary'
        ];
                
        return $colores[$this->estado] ?? 'secondary';
    }
}