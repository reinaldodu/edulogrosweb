<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class EstudianteRequest extends FormRequest
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
            'nombres' => 'required',
            'apellidos' => 'required',
            'grado_id' => 'required',
            'documento' => ['required',
                            Rule::unique('estudiantes')->ignore($this->id)                        
            ],
            'tipo_documento_id' => 'required',
            'exp_documento_id' => 'required',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'direccion' => 'required',
            'celular' => 'required',
            'pais_id' => 'required',
            'mpo_nacimiento_id' => 'required',
            'email' => ['required',
                        'email',
                        Rule::unique('users')->ignore($this->user_id)
            ],
            'eps' => 'required',
            'talla' => 'required',
            'peso' => 'required',
            'rh' => 'required',
            'tel_emergencia' => 'required',           
        ];
    }
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'max' => 'Supera la cantidad máxima de :max caracteres',
            'email.unique' => 'Ya existe este email en el sistema',
            'documento.unique' => 'Ya existe este documento en el sistema',
            'mpo_nacimiento_id.required' => 'El municipio es requerido',
            'tipo_documento_id.required' => 'El tipo de documento es requerido',
            'exp_documento_id.required' => 'El municipio es requerido',
            'pais_id.required' => 'El país es requerido',
            'grado_id.required' => 'El grado es requerido',
        ];        
    }
}
