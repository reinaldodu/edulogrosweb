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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('asignatura_id');
            $table->tinyInteger('tipo'); // 1: asistencia, 2: ausencia, 3: tarde
            $table->date('fecha');

            // Llaves foráneas
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            
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
        Schema::dropIfExists('asistencias');
    }
};
