<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];   

    //Deshabilitar timestamps
    public $timestamps = false;

    //Fijar el nombre de la tabla
    protected $table = "roles";

}
