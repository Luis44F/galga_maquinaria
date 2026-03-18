<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    
    protected $fillable = [
        'nombre',
        'tipo_documento',
        'numero_documento',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'departamento',
        'pais',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    // Relación: Un cliente tiene muchas ventas [citation:1][citation:2]
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}