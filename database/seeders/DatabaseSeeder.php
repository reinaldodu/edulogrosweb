<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Creamos 2 años academicos para hacer pruebas
        \App\Models\Year::factory()->create(['estado' => 'cerrado']);
        \App\Models\Year::factory()->create();

        //Fábrica de datos para la institución
        \App\Models\Institucion::factory()->create();

        //Ejecutamos los seeders de archivos CSV
        $this->call(DepartamentoSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(GradoSeeder::class);
        $this->call(ParentescoSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(PeriodoSeeder::class);
        $this->call(TipoObservacionSeeder::class);
        $this->call(TipoEvaluacionSeeder::class);
        $this->call(SistemaEvaluacionSeeder::class);
        
        //Ejecutamos los seeders de modelos
        $this->call(UserSeeder::class);
        $this->call(EstudianteSeeder::class);
        $this->call(ProfesorSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(GrupoSeeder::class);
        $this->call(TipoAsistenciaSeeder::class);
    }
}