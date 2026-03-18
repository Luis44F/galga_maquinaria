<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';
    
    protected $fillable = [
        'maquina_id',
        'venta_id',
        'tipo_documento',
        'numero_documento',
        'fecha_emision',
        'monto',
        'archivo_url',
        'observaciones'
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'monto' => 'decimal:2'
    ];

    // Relación inversa: Pertenece a una máquina
    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    // Relación inversa: Pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}