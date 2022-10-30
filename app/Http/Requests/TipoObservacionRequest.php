<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoObservacionRequest extends FormRequest
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
            //nombre único para el año académico y editable
            'nombre' => 'required|string|max:50|unique:tipo_observaciones,nombre,' . $this->id . ',id,year_id,' . session('periodoAcademico'),
            'abreviatura' => 'required|string|max:5',
        ];
    }
}
