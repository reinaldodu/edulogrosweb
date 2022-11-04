<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class ProfesorRequest extends FormRequest
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
            'documento' => ['required',
                            Rule::unique('profesores')->ignore($this->id)
            ],
            'tipo_documento_id' => 'required',
            'fecha_nacimiento' => 'required',
            'pais_id' => 'required',
            'direccion' => 'required',
            'celular' => 'required',
            'profesion' => 'required',
            'cargo' => 'required',
            'email' => ['required',
                        'email',
                        Rule::unique('users')->ignore($this->user_id)
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'max' => 'Supera la cantidad máxima de :max caracteres',            
            'email.unique' => 'Ya existe este email en el sistema',
            'documento.unique' => 'Ya existe este documento en el sistema',
            'pais_id.required' => 'El país es requerido',
            'tipo_documento_id.required' => 'El tipo de documento es requerido',
        ];
    }
}
