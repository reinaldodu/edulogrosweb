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
        Schema::create('observacion_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('observacion_id');
            $table->unsignedBigInteger('periodo_id');

            //Llaves foráneas
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('observacion_id')->references('id')->on('observaciones');
            $table->foreign('periodo_id')->references('id')->on('periodos');

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
        Schema::dropIfExists('observacion_estudiantes');
    }
};
