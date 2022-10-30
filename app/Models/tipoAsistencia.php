<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoAsistencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_asistencias';

    protected $fillable = [
        'id',
        'nombre',
        'abreviatura',
        'color',
        'year_id',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'tipo_id');
    }
    
    //Mutator para guardar el nombre inicial en mayúscula
    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst($value),
        );
    }
    
    //Mutator para guardar la abreviatura en mayúsculas
    protected function abreviatura(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value),
        );
    }
}
