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
        Schema::create('numeroexpedientes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_expediente')->default(0);
            $table->integer('ano_expediente')->default(0);
            $table->string('desc_expediente', 250)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numeroexpedientes');
    }
};
