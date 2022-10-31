<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'tipo_evaluaciones';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'year_id',
    ];

    //Un tipo de evaluación tiene varias evaluaciones -sistema de evaluación-
    public function evaluaciones()
    {
        return $this->hasMany(SistemaEvaluacion::class);
    }

    //Mutators primera letra en mayúscula para guardar
    protected function nombre(): Attribute {
        return Attribute::make(
            set: fn($value) => ucfirst($value),
        );
    }
  
    //Mutator convertir en mayúscula para guardar
    protected function abreviatura(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value),
        );
    }
}
