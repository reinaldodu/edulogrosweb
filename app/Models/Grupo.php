<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
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
        'grado_id',
        'director_id',
        'codirector_id',
        'year_id'
    ];

    //Un grupo pertenece a un grado
    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    //Un grupo pertenece a un director
    public function director()
    {
        return $this->belongsTo(Profesor::class);
    }

    //Un grupo pertenece a un codirector
    public function codirector()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class)->withPivot('year_id')->withTimestamps()->orderBy('apellidos');
    }

    //Un grupo tiene varias asignaciones académicas
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    //Un grupo tiene varios logros
    public function logros()
    {
        return $this->hasMany(Logro::class);
    }

    // Accessor descripcion grupo
    protected function descripcion(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value : '',
        );
    }

    // accessor nombre (mayúsculas)
    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
        );
    }
    
}
