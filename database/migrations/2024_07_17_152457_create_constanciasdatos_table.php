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
        Schema::create('constanciasdatos', function (Blueprint $table) {
            $table->id();
            $table->text('contenido');
            $table->string('descripcion_correlativo', 250)->default('-');
            $table->string('archivo_encabezado', 500)->default('-');
            $table->string('archivo_firma', 500)->default('-');
            $table->boolean('estado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constanciasdatos');
    }
};
