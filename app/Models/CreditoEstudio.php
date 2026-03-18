<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoEstudio extends Model
{
    use HasFactory;

    protected $table = 'creditos_estudio';
    
    protected $fillable = [
        'venta_id',
        'entidad_credito',
        'estado',
        'fecha_aprobacion',
        'monto_aprobado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_aprobacion' => 'date',
        'monto_aprobado' => 'decimal:2'
    ];

    // Relación inversa: Pertenece a una venta [citation:2][citation:3]
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}