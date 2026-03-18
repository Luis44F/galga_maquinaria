<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // 👈 Cambiado a proveedores_temp
    
    protected $fillable = [
        'nombre',
        'pais',
        'contacto',
        'email',
        'telefono',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];
}