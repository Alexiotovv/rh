<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expedientes', function (Blueprint $table) {
            $table->integer('plazo_meses')->nullable();
            $table->decimal('monto_solicitado', 12, 2)->nullable(); // 12 dígitos en total, 2 decimales
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expedientes', function (Blueprint $table) {
            $table->dropColumn('plazo_meses');
            $table->dropColumn('monto_solicitado');
        });
    }
};
