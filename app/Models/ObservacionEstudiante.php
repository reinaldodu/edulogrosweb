<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionEstudiante extends Model
{
    use HasFactory;

    protected $table = 'observacion_estudiantes';
    protected $fillable = [
        'estudiante_id',
        'observacion_id',
        'periodo_id',
        'year_id',
    ];

    // una observacionEstudiante pertenece a un periodo
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    // una observacionEstudiante pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // una observacionEstudiante pertenece a una observación
    public function observacion()
    {
        return $this->belongsTo(Observacion::class);
    }

}
