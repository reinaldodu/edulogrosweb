<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
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
        'area_id',
    ];

    //una asignatura pertenece a un área
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

     //Un asignatura tiene varias asignaciones académicas
     public function asignaciones()
     {
         return $this->hasMany(Asignacion::class);
     }

     //Una asignatura tiene varios logros
    public function logros()
    {
        return $this->hasMany(Logro::class);
    }
}
