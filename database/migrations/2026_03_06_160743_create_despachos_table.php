<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despachos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas');
            $table->string('guia_despacho', 100)->unique()->nullable();
            $table->string('transportista', 255)->nullable();
            $table->date('fecha_despacho')->nullable();
            $table->date('fecha_estimada_entrega')->nullable();
            $table->date('fecha_entrega_real')->nullable();
            $table->enum('estado', ['preparando', 'despachado', 'en_ruta', 'entregado', 'retrasado'])->default('preparando');
            $table->text('direccion_entrega')->nullable();
            $table->string('recibido_por', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despachos');
    }
};