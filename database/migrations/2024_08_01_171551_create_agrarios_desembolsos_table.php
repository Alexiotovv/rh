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
        Schema::create('agrarios_desembolsos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agrarios_creditos_id')->unsigned();
            $table->foreign('agrarios_creditos_id')->references('id')->on('agrarios_creditos')->onDelete('cascade');
            $table->string('numero_oficio_remitido', 250)->default('');
            $table->date('fecha_desembolso');
            $table->decimal('monto_desembolsado', 10, 2)->default(0.00);
            $table->date('fecha_carga');
            $table->date('fecha_pago');
            $table->string('archivo_oficio', 250)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agrarios_desembolsos');
    }
};
