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
            'color' => '#36D399'
        ]);
    tipoAsistencia::create([
        'nombre' => 'Falta',
        'abreviatura' => 'F',
        'color' => '#FBBD23'
        ]);
        tipoAsistencia::create([
            'nombre' => 'Tarde',
            'abreviatura' => 'T',
            'color' => '#F87272'
        ]);
    }
}
