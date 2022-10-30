<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

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
            //nombre unico para el año academico y editable
            'nombre' => 'required|string|max:255|unique:grupos,nombre,' . $this->id . ',id,year_id,' . session('periodoAcademico'),
            'grado_id' => 'required',
            'director_id' => 'required',
            'codirector_id' => 'nullable|different:director_id',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'max' => 'Supera la cantidad máxima de :max caracteres',
            'grado_id.required' => 'El grado es requerido',
            'director_id.required' => 'El director es requerido',
            'different' => 'El director y codirector no puede ser el mismo',
        ];        
    }
}
