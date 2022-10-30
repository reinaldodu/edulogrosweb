<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'asignatura_id',
        'tipo_id',
        'fecha',
        'year_id',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function tipo()
    {
        return $this->belongsTo(tipoAsistencia::class);
    }

}
