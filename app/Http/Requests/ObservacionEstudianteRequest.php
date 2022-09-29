<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObservacionEstudianteRequest extends FormRequest
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
            'observaciones' => 'required',
            'estudiantes' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'observaciones.required' => 'Debe seleccionar al menos una observación',
            'estudiantes.required' => 'Debe seleccionar al menos un estudiante',
        ];
    }
}
