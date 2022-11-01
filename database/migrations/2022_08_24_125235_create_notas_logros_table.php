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
            $table->foreignId('estudiante_id')->constrained('estudiantes');
            $table->foreignId('logro_id')->references('id')->on('logros');
            //actividad_id puede ser null mientras que el campo evalua_actividades = false en el sistema_evaluacion
            $table->foreignId('actividad_id')->nullable()->constrained('actividades_logros');
            $table->smallInteger('nota')->nullable();
            $table->foreignId('year_id')->constrained('years');
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
        Schema::dropIfExists('notas_logros');
    }
};
