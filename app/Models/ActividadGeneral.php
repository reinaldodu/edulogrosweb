<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadGeneral extends Model
{
    use HasFactory;

    //Fijar el nombre de la tabla
    protected $table = "actividades_generales";
    protected $fillable = [
        'tipo_evaluacion_id',
        'periodo_id',
        'grupo_id',
        'asignatura_id',
        'nombre',
        'descripcion',
        'fecha',
        'year_id',
    ];
}
