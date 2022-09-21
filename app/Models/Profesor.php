<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Profesor extends Model
{
    use HasFactory;

    //Fijar el nombre de la tabla
    protected $table = "profesores";

    protected $appends = ['edad'];  //atributo creado con el accessor edad

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [        
        'nombres',
        'apellidos',
        'documento',
        'tipo_documento',
        'fecha_nacimiento',
        'pais_id',
        'direccion',        
        'telefono',
        'foto',
        'celular',
        'profesion',
        'cargo',
        'escalafon',        
        'user_id',        
    ];
    
    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Un profesor tiene varias asignaciones académicas
    public function asignaciones()
    {
        return $this->hasMany(AsignacionAcademica::class);
    }

    //Un profesor tiene un grupo a cargo (director/codirector)
    public function grupo()
    {
        return $this->hasOne(Grupo::class);
    }

    //Accesor para la edad del profesor
    protected function edad(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::parse($attributes['fecha_nacimiento'])->age,
        );
    }
}
