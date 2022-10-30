<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'abreviatura',
        'fecha_inicio',
        'fecha_fin',
        'porcentaje',
        'activo',
        'year_id',
    ];

    // Un periodo tiene varios logros
    public function logros()
    {
        return $this->hasMany(Logro::class);
    }

    // Un periodo tiene varias notas_generales
    public function notasGenerales()
    {
        return $this->hasMany(NotaGeneral::class);
    }

    // Un periodo tiene varias actividades_generales
    public function actividadesGenerales()
    {
        return $this->hasMany(ActividadGeneral::class);
    }

    //Accessor para cambiar 1/0 por Si/No
    protected function activo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value == 1 ? 'Si' : 'No',
        );
    }

    //Mutator primera letra en mayúscula para guardar el nombre del periodo
    protected function nombre(): Attribute {
        return Attribute::make(
            set: fn($value) => ucfirst($value),
        );
    }

    //Mutator para guardar la abreviatura en mayusculas
    protected function abreviatura(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value),
        );
    }
}
