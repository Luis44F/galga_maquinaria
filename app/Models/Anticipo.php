<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{
    use HasFactory;

    protected $table = 'anticipos';
    
    protected $fillable = [
        'venta_id',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'referencia',
        'registrado_por',
        'observaciones'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date'
    ];

    // Relación inversa: Pertenece a una venta [citation:2][citation:3]
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    // Relación inversa: Pertenece a un vendedor
    public function registradoPor()
    {
        return $this->belongsTo(Vendedor::class, 'registrado_por');
    }
}