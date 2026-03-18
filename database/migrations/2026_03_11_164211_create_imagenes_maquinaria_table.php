<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('imagenes_maquinaria')) {
            Schema::create('imagenes_maquinaria', function (Blueprint $table) {
                $table->id();
                $table->foreignId('maquinaria_id')
                      ->constrained('maquinas')  // ← ¡OJO! apunta a 'maquinas'
                      ->cascadeOnDelete();
                $table->string('ruta');
                $table->boolean('es_principal')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('imagenes_maquinaria');
    }
};