<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\SistemaEvaluacion;
use App\Models\Grado;

class SistemaEvaluacionRequest extends FormRequest
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
        return 
        [
            'grado_id' => 'required',
            
            'tipo_evaluacion_id' => 
            [
                'required',
                //Validar en cada grado que el tipo de evaluacion no se repita
                function ($attribute, $value, $fail) {
                    //Validación al usar el método store
                    if ($this->method() == 'POST') {
                        foreach ($this->grado_id as $IdGrado) { //$this->grado_id es un array
                            $verificar_evaluacion = SistemaEvaluacion::with('grado', 'tipo_evaluacion')
                                                                    ->where('year_id', session('periodoAcademico'))
                                                                    ->where('grado_id', $IdGrado)
                                                                    ->where('tipo_evaluacion_id', $value) // $value = $this->tipo_evaluacion_id
                                                                    ->first();
                            if ($verificar_evaluacion) {
                                $fail('Ya existe el tipo de evaluación '. $verificar_evaluacion->tipo_evaluacion->nombre . ' para el grado '. $verificar_evaluacion->grado->nombre);
                            }
                        }
                    }
                    //Validación al usar el método update
                    if ($this->method() == 'PUT') {
                        $verificar_evaluacion = SistemaEvaluacion::with('grado', 'tipo_evaluacion')
                                                                ->where('year_id', session('periodoAcademico'))
                                                                ->where('grado_id', $this->grado_id)
                                                                ->where('tipo_evaluacion_id', $value) // $value = $this->tipo_evaluacion_id
                                                                ->where('id', '!=', $this->id)
                                                                ->first();
                        if ($verificar_evaluacion) {
                            $fail('Ya existe el tipo de evaluación '. $verificar_evaluacion->tipo_evaluacion->nombre . ' para el grado '. $verificar_evaluacion->grado->nombre);
                        }
                    }
                }
            ],

        
            'porcentaje' => 
            [
                'required',
                'numeric',
                'between:1,100',                            
                //Verificar que la suma de los porcentajes de las evaluaciones en cada grado no sea superior a 100%
                function ($attribute, $value, $fail) {
                    //Validación al usar el método store
                    if ($this->method() == 'POST') {
                        foreach ($this->grado_id as $IdGrado) {  //$this->grado_id es un array
                            $grado = Grado::find($IdGrado);
                            $porcentaje = SistemaEvaluacion::where('year_id', session('periodoAcademico'))
                                                            ->where('grado_id', $IdGrado)
                                                            ->sum('porcentaje');
                            if ($porcentaje + $value > 100) {  // value = $this->porcentaje
                                $fail('El porcentaje total de las evaluaciones en el grado '. $grado->nombre .' no puede ser superior a 100%');
                            }
                        }
                    }
                    //Validación al usar el método update
                    if ($this->method() == 'PUT') {
                        $grado = Grado::find($this->grado_id);
                        $porcentaje = SistemaEvaluacion::where('year_id', session('periodoAcademico'))
                                                        ->where('grado_id', $this->grado_id)
                                                        ->where('id', '!=', $this->id)
                                                        ->sum('porcentaje');
                        if ($porcentaje + $value > 100) { //value = $this->porcentaje
                            $fail('El porcentaje total de las evaluaciones en el grado '. $grado->nombre .' no puede ser superior a 100%');
                        }
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'grado_id.required' => 'El grado es requerido',
            'tipo_evaluacion_id.required' => 'El tipo de evaluación es requerida',
            'porcentaje.between' => 'El porcentaje debe ser un valor entre 1 y 100'
        ];        
    }
}
