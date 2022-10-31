<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class EscalaValoracion extends Model
{
    use HasFactory;

    protected $table='escala_valoraciones';

    protected $appends = ['url_imagen'];

    protected $fillable = [
        'grado_id',
        'nombre',
        'abreviatura',
        'imagen',
        'rango_inicial',
        'rango_final',
        'year_id',
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    // Accessor para obtener la url completa de la imagen de la escala de valoración
    public function urlImagen(): Attribute
    {
        return Attribute::make(
            //si la imagen no existe, se devuelve null
            get: fn($value, $attributes) => $attributes['imagen'] ? Storage::disk('public')->url($attributes['imagen']) : null,
        );
    }

    //mutator para guardar la abreviatura en mayúsculas
    public function abreviatura(): Attribute
    {
        return Attribute::make(
            set: fn($value, $attributes) => strtoupper($value),
        );
    }
}
