<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('maquinas', function (Blueprint $table) {
            $table->string('modelo')->nullable()->after('modelo_id');
        });
    }

    public function down()
    {
        Schema::table('maquinas', function (Blueprint $table) {
            $table->dropColumn('modelo');
        });
    }
};