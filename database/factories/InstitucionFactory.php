<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institucion>
 */
class InstitucionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => 'Colegio de prueba',
            'slogan' => 'Cada día aprendemos algo nuevo',
            'descripcion' => 'Aquí se describe la institución',
            'resolucion' => 'Resolucion #2010 de 2022 MEN',
            'periodo_academico' => '2022-2023',
            'direccion' => 'Cra.20 #10-10',
            'telefono' => '8851129',
            'email' => 'info@colegio.edu.co',
            'rector' => 'Carlos Alberto Sánchez Rodríguez',
            'web' => 'https://elmejorcolegio.edu.co',
            'logo' => 'images/logo.png',
        ];
    }
}
