<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogroRequest extends FormRequest
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
            'logro' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'logro.required' => 'El campo es requerido',
            'logro.string' => 'El campo debe ser una cadena de texto',
            'logro.max' => 'El campo debe tener como máximo 255 caracteres',
        ];
    }
    
}
