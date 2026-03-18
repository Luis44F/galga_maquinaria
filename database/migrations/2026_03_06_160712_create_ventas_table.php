<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_venta', 50)->unique();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('vendedor_id')->nullable()->constrained('vendedores');
            $table->date('fecha_venta');
            $table->decimal('precio_total', 15, 2)->nullable();
            $table->decimal('anticipo', 15, 2)->default(0);
            $table->decimal('saldo_pendiente', 15, 2)->nullable();
            $table->enum('estado_pago', ['pendiente', 'parcial', 'pagado'])->default('pendiente');
            $table->enum('estado_despacho', ['pendiente', 'preparando', 'despachado', 'entregado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index('estado_pago');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};