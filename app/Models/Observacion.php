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
        'grado_id',
    ];

    //una observación pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    //una observación pertenece a un grado
    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    //una observación pertenece a un tipo de observación (Ej: Fortalezas, Debilidades, etc)
    public function tipo()
    {
        return $this->belongsTo(TipoObservacion::class);
    }
}
