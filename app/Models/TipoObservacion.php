<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoObservacion extends Model
{
    use HasFactory;

    protected $table = 'tipo_observaciones';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'year_id',
    ];

     //Un tipo de observación tiene varias observaciones
     public function observaciones()
     {
         return $this->hasMany(Observacion::class, 'tipo_id');  // Se escribe la llave foránea tipo_id debido a que el nombre del modelo es tipoObservacion y laravel mapea automaticamente la llave foránea como Modelo_id => tipo_observacion_id (siendo tipo_id)
     }

    //Mutator para guardar la abreviatura en mayúsculas
    protected function abreviatura(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value),
        );
    }

}
