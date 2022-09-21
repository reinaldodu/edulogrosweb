<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GrupoRequest extends FormRequest
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
            'nombre' => ['required',
                            Rule::unique('grupos')->ignore($this->id)
            ],
            'grado_id' => 'required',
            'director_id' => 'required',            
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'max' => 'Supera la cantidad máxima de :max caracteres',            
            'nombre.unique' => 'Este grupo ya existe',
            'grado_id.required' => 'El grado es requerido',
            'director_id.required' => 'El director es requerido',
        ];        
    }
}
