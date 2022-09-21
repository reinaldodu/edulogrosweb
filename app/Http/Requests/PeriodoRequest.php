<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
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
            'nombre' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('periodos')->ignore($this->id)
            ],
            'descripcion' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'abreviatura' => [
                                'required',
                                'string',
                                'max:10',
                                Rule::unique('periodos')->ignore($this->id)
            ],

            'porcentaje' => 
            [
                'required',
                'numeric',
                'between:1,100',
                //Validar que el porcentaje total no sea superior al 100%
                //Validación método store
                function ($attribute, $value, $fail) { 
                    if ($this->method() == 'POST') {
                        $porcentaje = Periodo::sum($attribute); //$attribute = 'porcentaje'
                        if ($porcentaje + $value > 100) {  //$value = $this->porcentaje
                            $fail('El porcentaje total excede al 100%');
                        }
                    }
                    //Validación método update
                    if ($this->method() == 'PUT') { 
                        $porcentaje = Periodo::where('id', '!=', $this->id)->sum($attribute); //$attribute = 'porcentaje'
                        if ($porcentaje + $value > 100) { //$value = $this->porcentaje
                            $fail('El porcentaje total excede al 100%');
                        }
                    }
                }
            ],
        ];
    }
}
