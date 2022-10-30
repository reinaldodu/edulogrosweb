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
        Schema::create('institucion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slogan')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('resolucion')->nullable();
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('rector');
            $table->string('web')->nullable();
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institucion');
    }
};
