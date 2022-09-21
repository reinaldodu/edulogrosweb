<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Municipio;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');  // Desactivamos la revisión de claves foráneas
        Municipio::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');  // Reactivamos la revisión de claves foráneas
  
        $csvFile = fopen(base_path("database/data/Municipios.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Municipio::create([
                    "id" => $data['0'],
                    "cod_dane" => $data['1'],
                    "nombre" => $data['2'],
                    "departamento_id" => $data['3']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);   

    }
}
