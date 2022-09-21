<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acudiente>
 */
class AcudienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'parentesco_id' => $this->faker->randomElement([1, 2]),
            'nombres' => $this->faker->firstname,
            'apellidos' => $this->faker->lastname,
            'documento' => $this->faker->numerify('##########'),
            'tipo_documento' => 'CC',            
            'fecha_nacimiento' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-20 years', $timezone = null),
            'pais_id' => 43,            
            'direccion' => $this->faker->address(),
            'barrio' => $this->faker->word,
            'telefono' => $this->faker->numerify('#######'),
            'celular' => $this->faker->numerify('300#######'),            
            'foto' => $this->faker->imageUrl(100, 100, 'people'),
            'profesion' => $this->faker->jobTitle,
            'cargo' => $this->faker->jobTitle,
            'empresa' => $this->faker->company,
            'tel_empresa' => $this->faker->numerify('#######'),
            'user_id' => \App\Models\User::where('rol_id', 4)->get()->random()->id,
        ];
    }
}
