<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    use HasFactory;

    protected $fillable = [
        'logro',
        'grupo_id',
        'asignatura_id',
        'periodo_id',
        'year_id',
    ];

    //un logro pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    //un logro pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    //un logro pertenece a un periodo
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    //un logro tiene muchas notas de logros
    public function notasLogros()
    {
        return $this->hasMany(NotaLogro::class);
    }

    //un logro tiene muchas actividades de logros
    public function actividadesLogros()
    {
        return $this->hasMany(ActividadLogro::class);
    }
}
