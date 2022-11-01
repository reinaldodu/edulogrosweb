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
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos');
            $table->foreignId('exp_documento_id')->constrained('municipios');
            $table->date('fecha_nacimiento');
            $table->foreignId('pais_id')->constrained('paises');
            $table->foreignId('mpo_nacimiento_id')->constrained('municipios');
            $table->char('genero', 1);
            $table->string('direccion');
            $table->string('barrio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular');            
            $table->string('foto')->nullable();
            $table->foreignId('user_id')->constrained('users');
            //Datos de la ficha medica
            $table->string('eps');
            $table->string('talla');
            $table->string('peso');
            $table->char('rh',5);
            $table->string('clinica')->nullable();
            $table->string('tel_emergencia');
            $table->string('alergias')->nullable();
            $table->string('observaciones')->nullable();
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
