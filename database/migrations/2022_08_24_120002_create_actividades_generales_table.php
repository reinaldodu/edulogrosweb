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
        Schema::create('actividades_generales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->date('fecha');
            $table->foreignId('tipo_evaluacion_id')->constrained('tipo_evaluaciones');
            $table->foreignId('asignatura_id')->constrained('asignaturas');
            $table->foreignId('periodo_id')->constrained('periodos');
            $table->foreignId('grupo_id')->constrained('grupos');
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
        Schema::dropIfExists('actividades_generales');
    }
};
