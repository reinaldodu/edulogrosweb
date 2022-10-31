<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Grado;
use App\Models\EscalaValoracion;

class EscalaValoracionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'grado_id' => 'required',
            'nombre' => 
            [
                'required',
                'string',
                'max:255',
                //Validar en cada grado que el nombre de la escala de valoración no se repita
                function ($attribute, $value, $fail) {
                     //Validación al usar el método store                    
                     if ($this->method() == 'POST') {
                        foreach ($this->grado_id as $IdGrado) { //$this->grado_id es un array
                            $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                            ->where('year_id', session('periodoAcademico'))
                                                                            ->where('grado_id', $IdGrado)
                                                                            ->where('nombre', $value) // $value = $this->nombre
                                                                            ->first();
                            if ($verificar_escala_valoracion) {
                                $fail('Ya existe la escala de valoración '. $verificar_escala_valoracion->nombre . ' para el grado '. $verificar_escala_valoracion->grado->nombre);
                            }
                        }
                    }
                    //Validación al usar el método update
                    if ($this->method() == 'PUT') {
                        $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                        ->where('year_id', session('periodoAcademico'))
                                                                        ->where('grado_id', $this->grado_id)
                                                                        ->where('nombre', $value) // $value = $this->nombre
                                                                        ->where('id', '!=', $this->id)
                                                                        ->first();
                        if ($verificar_escala_valoracion) {
                            $fail('Ya existe la escala de valoración '. $verificar_escala_valoracion->nombre . ' para el grado '. $verificar_escala_valoracion->grado->nombre);
                        }
                    }
                }
                    
            ],

            'abreviatura' => 
            [
                'required',
                'string',
                'max:5',
                //Validar en cada grado que la abreviatura de la escala de valoración no se repita
                function ($attribute, $value, $fail) {
                     //Validación al usar el método store                    
                     if ($this->method() == 'POST') {
                        foreach ($this->grado_id as $IdGrado) { //$this->grado_id es un array
                            $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                            ->where('year_id', session('periodoAcademico'))
                                                                            ->where('grado_id', $IdGrado)
                                                                            ->where('abreviatura', $value) // $value = $this->abreviatura
                                                                            ->first();
                            if ($verificar_escala_valoracion) {
                                $fail('Ya existe la abreviatura '. $verificar_escala_valoracion->abreviatura . ' para el grado '. $verificar_escala_valoracion->grado->nombre);
                            }
                        }
                    }
                    //Validación al usar el método update
                    if ($this->method() == 'PUT') {
                        $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                        ->where('year_id', session('periodoAcademico'))
                                                                        ->where('grado_id', $this->grado_id)
                                                                        ->where('abreviatura', $value) // $value = $this->abreviatura
                                                                        ->where('id', '!=', $this->id)
                                                                        ->first();
                        if ($verificar_escala_valoracion) {
                            $fail('Ya existe la abreviatura '. $verificar_escala_valoracion->abreviatura . ' para el grado '. $verificar_escala_valoracion->grado->nombre);
                        }
                    }
                }
            ],

            'rango_inicial' => 
            [
                'required',
                'numeric',
                'between:1,100',
                //Validar que el rango inicial sea mayor al último rango final guardado
                function ($attribute, $value, $fail) {
                     
                    //Validación al usar el método store                    
                     if ($this->method() == 'POST') {
                        foreach ($this->grado_id as $IdGrado) { //$this->grado_id es un array
                            $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                            ->where('year_id', session('periodoAcademico'))
                                                                            ->where('grado_id', $IdGrado)
                                                                            ->orderBy('rango_final', 'desc')
                                                                            ->first();
                            if ($verificar_escala_valoracion) {
                                if ($verificar_escala_valoracion->rango_final === 100) {
                                    $fail('No se pueden crear más escalas de valoración para el grado '. $verificar_escala_valoracion->grado->nombre);
                                }
                                
                                elseif ($verificar_escala_valoracion->rango_final >= $value) {
                                    $fail('El rango inicial del grado '. $verificar_escala_valoracion->grado->nombre . ' debe ser mayor a '. $verificar_escala_valoracion->rango_final);
                                }
                            }
                        }
                    }
                    //Validación al usar el método update
                    if ($this->method() == 'PUT') {
                        $rango_inicial = EscalaValoracion::find($this->id)->rango_inicial;
                        $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                        ->where('year_id', session('periodoAcademico'))
                                                                        ->where('grado_id', $this->grado_id)
                                                                        ->where('rango_final', '<', $rango_inicial)
                                                                        ->where('id', '!=', $this->id)
                                                                        ->orderBy('rango_final', 'desc')
                                                                        ->first();
                        if ($verificar_escala_valoracion) {
                            if ($verificar_escala_valoracion->rango_final >= $value) {
                                $fail('El rango inicial del grado '. $verificar_escala_valoracion->grado->nombre . ' debe ser mayor a '. $verificar_escala_valoracion->rango_final);
                            }
                        }
                    }
                }
            ],

            'rango_final' => 
            [
                'required',
                'numeric',
                'between:1,100',
                'gte:rango_inicial',
                //Validar que el rango final sea menor al rango inicial de la siguiente escala de valoracion
                function ($attribute, $value, $fail) {
                    if ($this->method() == 'PUT') {
                        $rango_final = EscalaValoracion::find($this->id)->rango_final;
                        $verificar_escala_valoracion = EscalaValoracion::with('grado')
                                                                        ->where('year_id', session('periodoAcademico'))
                                                                        ->where('grado_id', $this->grado_id)
                                                                        ->where('rango_inicial', '>', $rango_final)
                                                                        ->where('id', '!=', $this->id)
                                                                        ->orderBy('rango_inicial')
                                                                        ->first();
                        
                        if ($verificar_escala_valoracion) {
                            if ($value >= $verificar_escala_valoracion->rango_inicial) {
                                $fail('El rango final del grado '. $verificar_escala_valoracion->grado->nombre . ' debe ser menor a '. $verificar_escala_valoracion->rango_inicial);
                            }
                        }
                    }
                }
            ],

            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }

    public function messages()
    {
        return [
            'grado_id.required' => 'El grado es obligatorio',
        ];
    }
}
