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
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->decimal('monto_pagar', 12, 4)->default(0.0000)->change();
            $table->decimal('interes_aplicado', 12, 4)->default(0.0000)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->decimal('monto_pagar', 12, 4)->default(0.0000)->change();
            $table->decimal('interes_aplicado', 12, 4)->default(0.0000)->change();
        });
    }
};
