<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoEvaluacionRequest extends FormRequest
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
            'nombre' => 'required|unique:tipo_evaluaciones,nombre,' . $this->id . ',id,year_id,' . session('periodoAcademico'),

            //abreviatura única para el año academico actual y editable
            'abreviatura' => 'required|unique:tipo_evaluaciones,abreviatura,' . $this->id . ',id,year_id,' . session('periodoAcademico'),
        ];
    }
}
