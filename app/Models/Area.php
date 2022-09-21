<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombre',
        'descripcion',        
    ];

    //Un área tiene varias asignaturas
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class)->orderBy('nombre');
    }
}
