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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('director_id');
            $table->unsignedBigInteger('codirector_id')->nullable();
            
            //Tablas con llaves foráneas
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->foreign('director_id')->references('id')->on('profesores');
            $table->foreign('codirector_id')->references('id')->on('profesores');
            
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
        Schema::dropIfExists('grupos');
    }
};
