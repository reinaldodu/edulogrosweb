<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoAsistencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_asistencias';
    
    protected $fillable = [
        'nombre',
        'abreviatura',
        'color',
    ];
    
}
