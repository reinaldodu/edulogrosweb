<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaLogro extends Model
{
    use HasFactory;

    //Fijar el nombre de la tabla
    protected $table = "notas_logros";

    protected $fillable = [
        'estudiante_id',
        'logro_id',
        'actividad_id',
        'nota',
        'year_id',
    ];

    // una nota pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // una nota pertenece a un logro
    public function logro()
    {
        return $this->belongsTo(Logro::class);
    }
    
}
