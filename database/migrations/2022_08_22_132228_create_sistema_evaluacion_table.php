<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grado_id')->constrained('grados');
            $table->foreignId('tipo_evaluacion_id')->constrained('tipo_evaluaciones');  // La evaluación puede ser por logros o general (ej: congnitiva, convivencia, etc )
            $table->smallInteger('porcentaje');
            $table->boolean('evalua_actividades')->default(false);  // Si es true se pueden evaluar varias actividades de acuerdo al tipo de evaluación (logro o general), sino se evalua una sola nota por cada tipo de evaluación general y una nota por cada logro
            $table->foreignId('year_id')->constrained('years');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sistema_evaluacion');
    }
};
