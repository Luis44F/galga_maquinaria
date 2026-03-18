<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maquinas_modelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100);
            $table->string('tipo_maquina', 255)->nullable();
            $table->text('especificaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->index('modelo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maquinas_modelos');
    }
};