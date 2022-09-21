<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObservacionRequest extends FormRequest
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
            'observacion' => 'required',
            'tipo_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'observacion.required' => 'Observación vacia',
            'tipo_id.required' => 'Seleccione un tipo',
        ];
    }
}
