<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maquina_id')->nullable()->constrained('maquinas');
            $table->foreignId('venta_id')->nullable()->constrained('ventas');
            $table->enum('tipo_documento', [
                'factura_compra', 'factura_venta', 'nota_credito', 
                'boleta', 'guia_despacho', 'certificado_origen'
            ]);
            $table->string('numero_documento', 100)->nullable();
            $table->date('fecha_emision')->nullable();
            $table->decimal('monto', 15, 2)->nullable();
            $table->string('archivo_url', 500)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index('tipo_documento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};