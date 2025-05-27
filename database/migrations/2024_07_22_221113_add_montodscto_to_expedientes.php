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
            $table->decimal('monto_dscto', 12, 4)->default(0.0000);
            $table->string('ordenanzadscto', 500)->default('');
            $table->string('ordenanzaarchivo', 500)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expedientes', function (Blueprint $table) {
            $table->dropColumn('monto_dscto');
            $table->dropColumn('ordenanzadscto');
            $table->dropColumn('ordenanzaarchivo');

        });
    }
};
