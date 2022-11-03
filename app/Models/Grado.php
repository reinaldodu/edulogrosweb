<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;
    
    //Deshabilitar timestamps
    public $timestamps = false;

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class)->withPivot('year_id', 'estado_id')->withTimestamps();
    }
}
