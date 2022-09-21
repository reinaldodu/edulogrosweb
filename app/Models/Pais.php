<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    //Deshabilitar timestamps
    public $timestamps = false;

    //Fijar el nombre de la tabla
    protected $table = "paises";


}
