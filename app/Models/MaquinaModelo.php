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
        'tipo_maquina',     // Estandarizado según tu corrección
        'especificaciones',  // Para detalles técnicos
        'descripcion',       // Mantenido de tu versión previa
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'especificaciones' => 'array' // Útil si guardas las specs como JSON
    ];

    /**
     * Relación con la categoría (Una categoría tiene muchos modelos)
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación con máquinas individuales (Un modelo tiene muchas máquinas físicas)
     * ✅ Esta es la relación inversa necesaria para Maquina::modelo()
     */
    public function maquinas()
    {
        return $this->hasMany(Maquina::class, 'modelo_id');
    }

    /**
     * Scope para modelos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Accessor para nombre completo (Marca + Modelo)
     * Útil para mostrar en selects o reportes
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->marca} {$this->modelo}";
    }
}