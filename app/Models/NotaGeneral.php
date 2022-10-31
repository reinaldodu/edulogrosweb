<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaGeneral extends Model
{
    use HasFactory;

    //Fijar el nombre de la tabla
    protected $table = "notas_generales";

    protected $fillable = [
        'estudiante_id',
        'tipo_evaluacion_id',
        'actividad_id',        
        'asignatura_id',
        'periodo_id',
        'grupo_id',
        'nota',
        'year_id',
    ];

    //una nota pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
