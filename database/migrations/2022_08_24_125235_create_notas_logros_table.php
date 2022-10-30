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
        Schema::create('notas_logros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('logro_id');
            //actividad_id puede ser null mientras que el campo evalua_actividades = false en el sistema_evaluacion
            $table->unsignedBigInteger('actividad_id')->nullable();
            $table->smallInteger('nota')->nullable();
            $table->unsignedBigInteger('year_id');
            $table->timestamps();

            //Llaves foráneas
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('logro_id')->references('id')->on('logros');
            $table->foreign('actividad_id')->references('id')->on('actividades_logros');
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
        Schema::dropIfExists('notas_logros');
    }
};
