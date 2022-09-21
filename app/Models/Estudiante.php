<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Estudiante extends Model
{
    use HasFactory;

    protected $appends = ['edad'];  //atributo creado con el accessor edad

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'grado_id',
        'documento',
        'tipo_documento',
        'exp_documento_id',
        'fecha_nacimiento',
        'genero',
        'direccion',
        'barrio',
        'telefono',
        'foto',
        'celular',        
        'pais_id',
        'mpo_nacimiento_id',
        'eps',
        'talla',
        'peso',
        'rh',
        'clinica',
        'tel_emergencia',
        'alergias',        
        'observaciones',
        'user_id'
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function municipio_doc()
    {
        return $this->belongsTo(Municipio::class, 'exp_documento_id');
    }

    public function municipio_nacimiento()
    {
        return $this->belongsTo(Municipio::class, 'mpo_nacimiento_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }   

    public function acudientes()
    {
        return $this->belongsToMany(Acudiente::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //notas-logros del estudiante
    public function notasLogros()
    {
        return $this->hasMany(NotaLogro::class);
    }

    //notas-generales del estudiante
    public function notasGenerales()
    {
        return $this->hasMany(NotaGeneral::class);
    }

    //Accesor para la edad del estudiante
    protected function edad(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::parse($attributes['fecha_nacimiento'])->age,
        );
    }
}
