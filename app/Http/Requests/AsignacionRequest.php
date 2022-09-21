<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignacionRequest extends FormRequest
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
            'profesor_id' => 'required',
            'asignatura_id' => 'required',
            'grupo_id' => 'required',
            'intensidad_horaria' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'profesor_id.required' => 'El profesor es requerido',
            'asignatura_id.required' => 'La asignatura es requerida',
            'grupo_id.required' => 'El grupo es requerido',
            'intensidad_horaria.required' => 'La intensidad horaria es requerida',
        ];        
    }
}
