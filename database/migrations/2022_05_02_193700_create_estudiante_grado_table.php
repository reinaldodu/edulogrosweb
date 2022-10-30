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
        Schema::create('estudiante_grado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('year_id');
            $table->timestamps();

            //Llaves foráneas
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('grado_id')->references('id')->on('grados');
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
        Schema::dropIfExists('estudiante_grado');
    }
};
