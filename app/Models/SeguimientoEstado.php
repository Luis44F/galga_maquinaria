<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoEstado extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_estados';
    
    protected $fillable = [
        'maquina_id',
        'estado_anterior',
        'estado_nuevo',
        'fecha_cambio',
        'usuario_cambio',
        'observaciones'
    ];

    protected $casts = [
        'fecha_cambio' => 'datetime'
    ];

    /**
     * Relación con la máquina
     */
    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    /**
     * ✅ RELACIÓN CON USUARIO (LA QUE FALTA)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_cambio');
    }
}