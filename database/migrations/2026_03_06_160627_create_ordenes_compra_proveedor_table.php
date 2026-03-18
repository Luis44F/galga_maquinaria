<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_compra_proveedor', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden', 50)->unique();
            $table->string('proveedor', 255)->nullable();
            $table->string('pais_origen', 100)->nullable();
            $table->date('fecha_orden');
            $table->date('fecha_estimada_llegada')->nullable();
            $table->date('fecha_llegada_real')->nullable();
            $table->enum('estado', ['pendiente', 'en_transito', 'recibida', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('vendedores');
            $table->timestamps();
            
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra_proveedor');
    }
};