<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
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
            'nombre' => 'required|string|max:255|unique:contratos,nombre,' . $this->id . ',id,year_id,' . session('periodoAcademico'),
            'plantilla' => 'required|mimes:doc,docx,rtf|max:8048',
        ];
    }

    public function messages()
    {
        return [
            'plantilla' => 'Debe seleccionar un archivo de plantilla'
        ];
    }
}
