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
        Schema::create('acudientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parentesco_id')->constrained('parentescos');
            $table->string('apellidos');
            $table->string('nombres');
            $table->string('documento')->unique();
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos');
            $table->date('fecha_nacimiento');
            $table->foreignId('pais_id')->constrained('paises');
            $table->string('direccion');
            $table->string('barrio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular');            
            $table->string('foto')->nullable();
            $table->string('profesion');
            $table->string('cargo')->nullable();
            $table->string('empresa')->nullable();
            $table->string('tel_empresa')->nullable();
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('acudientes');
    }
};
