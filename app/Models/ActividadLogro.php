<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadLogro extends Model
{
    use HasFactory;

    protected $table='actividades_logros';
    protected $fillable = [
        'logro_id',
        'nombre',
        'descripcion',
        'fecha',
        'year_id',
    ];

    // Una actividad pertenece a un logro
    public function logro()
    {
        return $this->belongsTo(Logro::class);
    }

}
