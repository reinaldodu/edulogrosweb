<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Institucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'slogan',
        'descripcion',
        'resolucion',
        'direccion',
        'telefono',
        'rector',
        'email',
        'web',
        'logo',
    ];

    //Deshabilitar timestamps
    public $timestamps = false;

    //Fijar el nombre de la tabla
    protected $table = "institucion";

    // Accessor para obtener la url completa de la imagen del logo
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Storage::disk('public')->url($attributes['logo']),
        );
    }
}
