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
            $table->foreignId('tipo_credito_id')
              ->nullable()
              ->constrained('tipo_creditos')
              ->nullOnDelete(); // Puedes usar cascadeOnDelete() si prefieres
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expedientes', function (Blueprint $table) {
            $table->dropForeign(['tipo_credito_id']);
            $table->dropColumn('tipo_credito_id');
        });
    }
};
