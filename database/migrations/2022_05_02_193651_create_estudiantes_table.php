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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            //Datos personales
            $table->string('apellidos');
            $table->string('nombres');
            $table->string('documento')->unique();
            $table->char('tipo_documento',5);
            $table->unsignedBigInteger('exp_documento_id');
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('pais_id');
            $table->unsignedBigInteger('mpo_nacimiento_id');
            $table->char('genero', 1);
            $table->string('direccion');
            $table->string('barrio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular');            
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('user_id');

            //Datos de la ficha medica
            $table->string('eps');
            $table->string('talla');
            $table->string('peso');
            $table->char('rh',5);
            $table->string('clinica')->nullable();
            $table->string('tel_emergencia');
            $table->string('alergias')->nullable();
            $table->string('observaciones')->nullable();

            //Tablas con llaves foráneas            
            $table->foreign('exp_documento_id')->references('id')->on('municipios');
            $table->foreign('mpo_nacimiento_id')->references('id')->on('municipios');
            $table->foreign('pais_id')->references('id')->on('paises');
            $table->foreign('grado_id')->references('id')->on('grados');
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
        Schema::dropIfExists('estudiantes');
    }
};
