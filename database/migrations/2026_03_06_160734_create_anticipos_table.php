<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anticipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
            $table->decimal('monto', 15, 2);
            $table->date('fecha_pago');
            $table->enum('metodo_pago', ['transferencia', 'cheque', 'efectivo', 'otro'])->default('transferencia');
            $table->string('referencia', 100)->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('vendedores');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anticipos');
    }
};