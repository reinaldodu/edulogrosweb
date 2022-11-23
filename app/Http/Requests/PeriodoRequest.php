<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Periodo;

class PeriodoRequest extends FormRequest
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
            //nombre único para el año academico actual y editable
            'nombre' => 'required|string|max:255|unique:periodos,nombre,' . $this->id . ',id,year_id,' . session('periodoAcademico'),
            'descripcion' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            //abreviatura única para el año academico actual y editable
            'abreviatura' => 'required|string|max:10|unique:periodos,abreviatura,' . $this->id . ',id,year_id,' . session('periodoAcademico'),

            'porcentaje' => 
            [
                'required',
                'numeric',
                'between:1,100',
                //Validar que el porcentaje total no sea superior al 100% para el año academico                
                //Validación método store
                function ($attribute, $value, $fail) { 
                    if ($this->method() == 'POST') {
                        $porcentaje = Periodo::where('year_id', session('periodoAcademico'))
                                             ->sum($attribute); //$attribute = 'porcentaje'
                        if ($porcentaje + $value > 100) {  //$value = $this->porcentaje
                            $fail('El porcentaje total excede al 100%');
                        }
                    }
                    //Validación método update
                    if ($this->method() == 'PUT') { 
                        $porcentaje = Periodo::where('id', '!=', $this->id)
                                             ->where('year_id', session('periodoAcademico'))
                                             ->sum($attribute); //$attribute = 'porcentaje'
                        if ($porcentaje + $value > 100) { //$value = $this->porcentaje
                            $fail('El porcentaje total excede al 100%');
                        }
                    }
                }
            ],
        ];
    }
}
