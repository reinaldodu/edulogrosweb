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
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();

            $table->string('apellidos');
            $table->string('nombres');
            $table->string('documento')->unique();
            $table->char('tipo_documento',5);
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('pais_id');
            $table->string('direccion');            
            $table->string('telefono')->nullable();
            $table->string('celular');
            $table->string('foto')->nullable();
            $table->string('profesion');
            $table->string('cargo');
            $table->string('escalafon')->nullable();
            $table->unsignedBigInteger('user_id');

             //Tablas con llaves foráneas
             $table->foreign('pais_id')->references('id')->on('paises');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('profesores');
    }
};
