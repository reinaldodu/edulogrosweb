<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Year>
 */
class YearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => 'Periodo académico sin nombre',
            'descripcion' => 'Descripción del periodo académico',
            'fecha_inicio' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
            'fecha_fin' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = null),
        ];
    }
}
