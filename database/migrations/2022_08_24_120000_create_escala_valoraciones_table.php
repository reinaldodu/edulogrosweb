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
        Schema::create('escala_valoraciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('abreviatura');
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('grado_id');
            $table->smallInteger('rango_inicial');
            $table->smallInteger('rango_final');            

            //Llave foránea
            $table->foreign('grado_id')->references('id')->on('grados');
            
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
        Schema::dropIfExists('escala_valoraciones');
    }
};
