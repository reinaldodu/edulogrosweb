<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesor>
 */
class ProfesorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $nombre = $this->faker->firstname;
        $apellido = $this->faker->lastname;
        return [            
            'nombres' => $nombre,
            'apellidos' => $apellido,
            'documento' => $this->faker->numerify('##########'),
            'tipo_documento_id' => 3, //Documento C.C.
            'fecha_nacimiento' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-20 years', $timezone = null),
            'pais_id' => 43,            
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->numerify('#######'),
            'celular' => $this->faker->numerify('300#######'),
            //'foto' => 'https://i.pravatar.cc/300',
            //'foto' => $this->faker->imageUrl(100, 100, 'people'),
            'foto' => 'https://source.unsplash.com/random/200x200/?face',
            'profesion' => $this->faker->jobTitle,
            'cargo' => $this->faker->jobTitle,
            'escalafon' => $this->faker->numberBetween(1,14),
            //asignar un usuario al profesor
            'user_id' => \App\Models\User::create([
                'name' => $nombre . ' ' . $apellido,
                'email' => $this->faker->unique()->safeEmail,
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'rol_id' => 5,  //rol profesor
            ])->id,
        ];
    }
}
