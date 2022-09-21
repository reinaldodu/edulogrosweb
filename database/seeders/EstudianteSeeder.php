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
        //Fábrica de datos para la relación muchos a muchos usando el método has                       
        //\App\Models\Estudiante::factory(200)->has(\App\Models\Acudiente::factory()->count(2))->create();

        \App\Models\Estudiante::factory()
                                ->count(200)
                                ->hasAcudientes(2)
                                ->create();
    }
}
