<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //200 usuarios para estudiantes
        \App\Models\User::factory(200)->create(['rol_id' => 3]);

        //400 usuarios para acudientes
        \App\Models\User::factory(400)->create(['rol_id' => 4]);

        //50 usuarios para profesores
        \App\Models\User::factory(50)->create(['rol_id' => 5]);

        //5 usuarios para Coordinador
        \App\Models\User::factory(5)->create(['rol_id' => 2]);

        //1 usuario administrador
        \App\Models\User::factory(1)->create([
                'name' => 'Reinaldo Duque',
                'email' => 'reinaldodu@gmail.com',
                'password' => bcrypt('1'),
                'rol_id' => 1
        ]);
        
    }
}
