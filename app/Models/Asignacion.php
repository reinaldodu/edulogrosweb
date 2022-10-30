<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $table='asignaciones';  //Tabla de la carga academica de cada profesor.

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'intensidad_horaria',
        'grupo_id',
        'profesor_id',
        'asignatura_id',
        'year_id',
    ];
    
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

}
