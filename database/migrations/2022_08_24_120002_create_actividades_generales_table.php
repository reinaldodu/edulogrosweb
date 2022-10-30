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
            $table->unsignedBigInteger('tipo_evaluacion_id');
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('year_id');
            $table->timestamps();

            //Llaves foráneas
            $table->foreign('tipo_evaluacion_id')->references('id')->on('tipo_evaluaciones');
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
        Schema::dropIfExists('actividades_generales');
    }
};
