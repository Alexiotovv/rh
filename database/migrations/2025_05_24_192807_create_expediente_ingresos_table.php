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
        Schema::create('expediente_ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained()->onDelete('cascade');
            $table->decimal('monto', 12, 2)->nullable();
            $table->foreignId('ingreso_id')->constrained('ingresos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expediente_ingresos');
    }
};
