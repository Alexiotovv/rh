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
        Schema::table('deudores', function (Blueprint $table) {
             $table->foreignId('condicion_laboral_id')
              ->nullable()
              ->constrained('condicion_laborals')
              ->nullOnDelete(); // o ->cascadeOnDelete() si prefieres
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deudores', function (Blueprint $table) {
            $table->dropForeign(['condicion_laborals_id']);
            $table->dropColumn('condicion_laborals_id');
        });
    }
};
