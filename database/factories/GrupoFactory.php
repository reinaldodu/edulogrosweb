<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grupo>
 */
class GrupoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->word,
            'descripcion' => $this->faker->sentence,
            'grado_id' => \App\Models\Grado::all()->random()->id,
            'director_id' => \App\Models\Profesor::all()->random()->id,
            'codirector_id' => \App\Models\Profesor::all()->random()->id,
            'year_id' => 1,
        ];
    }
}
