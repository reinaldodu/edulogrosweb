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
        $nombre = $this->faker->firstname;
        $apellido = $this->faker->lastname;
        return [
            'parentesco_id' => $this->faker->randomElement([1, 2]),
            'nombres' => $nombre,
            'apellidos' => $apellido,
            'documento' => $this->faker->numerify('##########'),
            'tipo_documento_id' => 3,  //Documento C.C.
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
            //asignar un usuario al acudiente
            'user_id' => \App\Models\User::create([
                'name' => $nombre . ' ' . $apellido,
                'email' => $this->faker->unique()->safeEmail,
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'rol_id' => 4,  //rol acudiente
            ])->id,
        ];
    }
}
