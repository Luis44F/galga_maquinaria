<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modelo_id')->constrained('maquinas_modelos');
            $table->string('numero_serie', 100)->unique()->nullable();
            $table->integer('año_fabricacion')->nullable();
            $table->enum('estado', [
                'disponible', 'en_transito', 'orden_pendiente', 
                'vendida', 'descontinuada', 'en_bodega', 'en_puerto', 
                'con_anticipo', 'en_fabricacion', 'entregada'
            ])->default('disponible');
            $table->string('ubicacion_actual', 255)->nullable();
            $table->decimal('precio_compra', 15, 2)->nullable();
            $table->decimal('precio_venta', 15, 2)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_venta')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->index('estado');
            $table->index('numero_serie');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maquinas');
    }
};