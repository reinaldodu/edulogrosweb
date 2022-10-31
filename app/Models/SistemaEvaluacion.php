<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'sistema_evaluacion';

    protected $fillable = [
        'grado_id',
        'tipo_evaluacion_id',
        'porcentaje',
        'evalua_actividades',
        'year_id',
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function tipo_evaluacion()
    {
        return $this->belongsTo(TipoEvaluacion::class);
    }
}
