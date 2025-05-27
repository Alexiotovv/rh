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
        Schema::create('agrarios_deudores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('distritos_id')->unsigned();
            $table->foreign('distritos_id')->references('id')->on('distritos')->onDelete('cascade');
            $table->string('nombres', 250)->default('');
            $table->string('apellidos', 250)->default('');
            $table->string('direccion_dni', 250)->default('');
            $table->string('direccion_actual', 250)->default('');
            $table->string('dni_ruc', 250)->default('');
            $table->string('telefono', 250)->default('');
            $table->string('mercado', 250)->default('');
            $table->string('actividad', 250)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agrarios_deudores');
    }
};
