<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estudiantes = \App\Models\Estudiante::factory()
                                ->count(200)
                                ->hasAcudientes(2)  //Creación de 2 acudientes por estudiante
                                ->create();
        //agregar un grado al azar a cada estudiante, el año 1 y el estado 1 (activo)
        $estudiantes->each(function ($estudiante) {            
            $estudiante->grados()->attach(
                \App\Models\Grado::inRandomOrder()->first()->id,
                ['year_id' => 1, 'estado_id' => 1]
            );
        });
    }
}
