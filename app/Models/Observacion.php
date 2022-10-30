<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'observaciones';

    protected $fillable = [
        'observacion',
        'tipo_id',
        'asignatura_id',
        'grupo_id',
        'year_id',
    ];

    //una observación pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    //una observación pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    //una observación pertenece a un tipo de observación (Ej: Fortalezas, Debilidades, etc)
    public function tipo()
    {
        return $this->belongsTo(TipoObservacion::class);
    }
}
