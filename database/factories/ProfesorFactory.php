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
        return [            
            'nombres' => $this->faker->firstname,
            'apellidos' => $this->faker->lastname,
            'documento' => $this->faker->numerify('##########'),
            'tipo_documento' => 'CC',            
            'fecha_nacimiento' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-20 years', $timezone = null),
            'pais_id' => 43,            
            'direccion' => $this->faker->address(),            
            'telefono' => $this->faker->numerify('#######'),
            'celular' => $this->faker->numerify('300#######'),            
            'foto' => 'https://source.unsplash.com/random/200x200/?face', //$this->faker->imageUrl(100, 100, 'people'),
            'profesion' => $this->faker->jobTitle,
            'cargo' => $this->faker->jobTitle,
            'escalafon' => $this->faker->numberBetween(1,14),
            'user_id' => \App\Models\User::where('rol_id', 5)->get()->random()->id,
        ];
    }
}
