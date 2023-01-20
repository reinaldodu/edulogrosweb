<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Periodo;

class PeriodoSeeder extends Seeder
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
            Periodo::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');  // Reactivamos la revisión de claves foráneas
        }
  
        $csvFile = fopen(base_path("database/data/Periodos.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Periodo::create([
                    "id" => $data['0'],
                    "nombre" => $data['1'],
                    "descripcion" => $data['2'],
                    "fecha_inicio" => $data['3'],
                    "fecha_fin" => $data['4'],
                    "abreviatura" => $data['5'],
                    "activo" => $data['6'],
                    "porcentaje" => $data['7'],
                    "year_id" => $data['8'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
