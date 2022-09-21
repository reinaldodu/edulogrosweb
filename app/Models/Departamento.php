<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    //Deshabilitar timestamps
    public $timestamps = false;

    //Un departamento tiene varios municipios
    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }
}