<?php

namespace App\Http\Requests;

use App\Models\EscalaValoracion;
use Illuminate\Foundation\Http\FormRequest;

class NotaLogroRequest extends FormRequest
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
        //Obtener el grado del grupo
        $grado = $this->route('logro')->grupo->grado_id;
        //Verificar la escala de valoración del grupo
        $verificar_escala_valoracion = EscalaValoracion::where('year_id', session('periodoAcademico'))
                                                        ->where('grado_id', $grado)->get();
        if (!$verificar_escala_valoracion->isEmpty()) {
            // obtener el valor mínimo y máximo de la escala de valoración
            $min = min($verificar_escala_valoracion->pluck('rango_inicial')->toArray());
            $max = max($verificar_escala_valoracion->pluck('rango_final')->toArray());            
        }
        return [
            'notas.*' => 
            [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($min, $max) {
                    if ($value < $min || $value > $max) {
                        $fail('La nota debe estar entre ' . $min . ' y ' . $max);
                    }
                }
            ]
        ];

    }

    public function messages()
    {
        return [
            'notas.*.numeric' => 'La nota debe ser un número',
            'notas.*.min' => 'La nota debe ser mayor o igual a 0',
            'notas.*.max' => 'La nota debe ser menor o igual a 100',
        ];
    }
}
