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
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->string('observacion');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('grupo_id');

            //Llaves foráneas
            $table->foreign('tipo_id')->references('id')->on('tipo_observaciones');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->foreign('grupo_id')->references('id')->on('grupos');

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
        Schema::dropIfExists('observaciones');
    }
};
