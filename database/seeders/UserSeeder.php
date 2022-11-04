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
        // usuario administrador
        \App\Models\User::factory(1)->create([
                'name' => 'Reinaldo Duque',
                'email' => 'reinaldodu@gmail.com',
                'password' => bcrypt('1'),
                'rol_id' => 1
        ]);
        
    }
}
