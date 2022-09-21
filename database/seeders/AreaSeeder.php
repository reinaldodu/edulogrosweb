<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fábrica de datos para 10 areas y 2 asignaturas por área
        \App\Models\Area::factory()
                            ->count(10)
                            ->hasAsignaturas(2)
                            ->create();
    }
}
