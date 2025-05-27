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
        Schema::create('constanciasemitidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carta', 300)->default('');
            $table->bigInteger('idConstanciasDatos')->unsigned();
            $table->foreign('idConstanciasDatos')->references('id')->on('constanciasdatos')->onDelete('cascade');
            $table->bigInteger('idExpediente')->unsigned();
            $table->foreign('idExpediente')->references('id')->on('expedientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constanciasemitidos');
    }
};
