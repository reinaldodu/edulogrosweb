<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\SistemaEvaluacion;

class SistemaEvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //si la base de datos es mysql se debe desactivar la revisión de claves foráneas
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');  // Desactivamos la revisión de claves foráneas
            SistemaEvaluacion::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');  // Reactivamos la revisión de claves foráneas
        }
  
        $csvFile = fopen(base_path("database/data/Sistema_Evaluacion.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                SistemaEvaluacion::create([
                    "id" => $data['0'],
                    "grado_id" => $data['1'],
                    "tipo_evaluacion_id" => $data['2'],
                    "porcentaje" => $data['3'],
                    "evalua_actividades" => $data['4'],
                    "year_id" => $data['5'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
