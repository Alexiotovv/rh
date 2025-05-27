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
        Schema::create('agrarios_creditos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agrariosdeudores_id')->unsigned();
            $table->foreign('agrariosdeudores_id')->references('id')->on('agrarios_deudores')->onDelete('cascade');
            $table->bigInteger('agrarios_tipocreditos_id')->unsigned();
            $table->foreign('agrarios_tipocreditos_id')->references('id')->on('agrarios_tipocreditos')->onDelete('cascade');
            $table->decimal('anulacion_monto', 10, 2)->default(0.00);
            $table->string('anulacion_resolucion', 250)->default('');
            $table->date('anulacion_fecha')->nullable();
            $table->decimal('monto_solicitado', 10, 2)->default(0.00);
            $table->decimal('monto_aprobado', 10, 2)->default(0.00);
            $table->decimal('tasa_interes', 10, 2)->default(0.00);
            $table->decimal('monto_cuota_pagar', 10, 2)->default(0.00);
            $table->integer('periodo_gracia')->default(0);
            $table->string('letra_gracia', 100)->default('');
            $table->integer('periodo_devolucion')->default(0);
            $table->string('letra_devolucion', 100)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agrarios_creditos');
    }
};
