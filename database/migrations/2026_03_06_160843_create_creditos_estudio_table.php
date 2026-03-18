<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creditos_estudio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas');
            $table->string('entidad_credito', 255)->nullable();
            $table->enum('estado', ['en_estudio', 'aprobado', 'rechazado'])->default('en_estudio');
            $table->date('fecha_aprobacion')->nullable();
            $table->decimal('monto_aprobado', 15, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creditos_estudio');
    }
};