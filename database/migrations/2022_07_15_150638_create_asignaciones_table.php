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
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('intensidad_horaria');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('profesor_id');
            $table->unsignedBigInteger('asignatura_id');

            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->foreign('profesor_id')->references('id')->on('profesores');
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
        Schema::dropIfExists('asignaciones');
    }
};
