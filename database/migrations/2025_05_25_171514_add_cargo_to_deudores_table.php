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
            $table->string('cargo')->nullable()->after('apellidos'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deudores', function (Blueprint $table) {
            $table->dropColumn('cargo');

        });
    }
};
