<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    //Deshabilitar timestamps
    public $timestamps = false;

    // un municipio pertenece a un departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}

