<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acudiente extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'parentesco_id',
        'nombres',
        'apellidos',
        'documento',
        'tipo_documento_id',
        'fecha_nacimiento',
        'pais_id',
        'direccion',
        'barrio',
        'telefono',
        'foto',
        'celular',
        'profesion',
        'cargo',
        'empresa',
        'tel_empresa',
        'user_id',
    ];

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class);
    }  

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
