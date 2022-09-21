<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Grado;

class GradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');  // Desactivamos la revisión de claves foráneas
        Grado::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');  // Reactivamos la revisión de claves foráneas
  
        $csvFile = fopen(base_path("database/data/Grados.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Grado::create([
                    "id" => $data['0'],
                    "nombre" => $data['1'],
                    "descripcion" => $data['2']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);

    }
}
