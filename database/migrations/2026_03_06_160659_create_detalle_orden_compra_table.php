<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_orden_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_compra_id')->constrained('ordenes_compra_proveedor')->onDelete('cascade');
            $table->foreignId('maquina_id')->nullable()->constrained('maquinas');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 15, 2)->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_orden_compra');
    }
};
