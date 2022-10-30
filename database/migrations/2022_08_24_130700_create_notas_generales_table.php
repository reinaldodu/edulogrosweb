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
        Schema::create('notas_generales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('tipo_evaluacion_id');
            //actividad_id puede ser null mientras que el campo evalua_actividades = false en el sistema_evaluacion
            $table->unsignedBigInteger('actividad_id')->nullable();
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('grupo_id');
            $table->smallInteger('nota')->nullable();
            $table->unsignedBigInteger('year_id');
            $table->timestamps();

            //Llaves foráneas
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('tipo_evaluacion_id')->references('id')->on('tipo_evaluaciones');            
            $table->foreign('actividad_id')->references('id')->on('actividades_generales');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->foreign('year_id')->references('id')->on('years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas_generales');
    }
};
