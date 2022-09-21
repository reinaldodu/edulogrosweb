<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
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
            'documento' => $this->faker->unique()->numerify('##########'),
            'tipo_documento' => 'TI',
            'exp_documento_id' => 953, //$this->faker->numberBetween(1,1000),
            'fecha_nacimiento' => $this->faker->dateTimeBetween($startDate = '-17 years', $endDate = '-4 years', $timezone = null),
            'pais_id' => 43,
            'mpo_nacimiento_id' => 953,
            'genero' => $this->faker->randomElement(['M', 'F']),
            'direccion' => $this->faker->address(),
            'barrio' => $this->faker->word,
            'telefono' => $this->faker->numerify('#######'),
            'celular' => $this->faker->numerify('300#######'),            
            'foto' => 'https://source.unsplash.com/random/200x200/?face',  // 'foto' => $this->faker->imageUrl(100, 100, 'people'),
            'grado_id' => $this->faker->numberBetween(1,14),
            'eps' => $this->faker->randomElement(['Compensar', 'Sura', 'Colsanitas']),            
            'talla' => $this->faker->numerify('1.' . $this->faker->numberBetween(1,99)),
            'peso' => $this->faker->numerify('##.#'),
            'rh' => $this->faker->randomElement(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']),            
            'clinica' => $this->faker->word,
            'tel_emergencia' => $this->faker->numerify('#######'),
            'alergias' => $this->faker->text(50),
            'observaciones' => $this->faker->randomElement([$this->faker->text(50), '']),
            'user_id' => \App\Models\User::where('rol_id',3)->get()->random()->id,
        ];
    }
}
