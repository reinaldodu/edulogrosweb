<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Parentesco;

class ParentescoSeeder extends Seeder
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
            Parentesco::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');  // Reactivamos la revisión de claves foráneas
        }
  
        $csvFile = fopen(base_path("database/data/Parentescos.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Parentesco::create([
                    "id" => $data['0'],
                    "nombre" => $data['1']                    
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);   
    }
}
