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
        Schema::create('logros', function (Blueprint $table) {
            $table->id();
            $table->string('logro');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('year_id');
            $table->timestamps();

            //Llaves foráneas
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->foreign('periodo_id')->references('id')->on('periodos');
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
        Schema::dropIfExists('logros');
    }
};
