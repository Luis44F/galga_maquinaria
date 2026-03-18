<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaquinaModelo extends Model
{
    use HasFactory;

    protected $table = 'maquinas_modelos';
    
    protected $fillable = [
        'categoria_id',
        'marca',
        'modelo',
        'tipo',
        'descripcion',
        'activo'
    ];

    // ✅ RELACIÓN CON CATEGORÍA (LA QUE FALTA)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación con máquinas
    public function maquinas()
    {
        return $this->hasMany(Maquina::class, 'modelo_id');
    }
}