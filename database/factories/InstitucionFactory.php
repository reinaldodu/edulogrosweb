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
            'nombre' => 'Nombre del colegio',
            'slogan' => 'Slogan del colegio',
            'descripcion' => 'Aquí se describe la institución',
            'resolucion' => 'Resolucion #',
            'direccion' => 'Dirección del colegio',
            'telefono' => 'Teléfono del colegio',
            'email' => 'email@colegio.edu.co',
            'rector' => 'Nombre del rector',
            'web' => 'web.colegio.edu.co',
            'logo' => 'images/logo.png',
        ];
    }
}
