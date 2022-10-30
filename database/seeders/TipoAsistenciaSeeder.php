<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\tipoAsistencia;

class TipoAsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tipoAsistencia::create([
            'nombre' => 'Asiste',
            'abreviatura' => 'A',
            'color' => '#36d399',
            'year_id' => 1,
        ]);
    tipoAsistencia::create([
        'nombre' => 'Falta',
        'abreviatura' => 'F',
        'color' => '#fbbd23',
        'year_id' => 1,
        ]);
        tipoAsistencia::create([
            'nombre' => 'Tarde',
            'abreviatura' => 'T',
            'color' => '#f87272',
            'year_id' => 1,
        ]);
    }
}
