<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenMaquinaria extends Model
{
    use HasFactory;

    protected $table = 'imagenes_maquinaria';

    protected $fillable = [
        'maquinaria_id',
        'ruta',
        'es_principal'
    ];

    protected $casts = [
        'es_principal' => 'boolean'
    ];

    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'maquinaria_id');
    }

    // Accesor para obtener URL completa de la imagen
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->ruta);
    }
}