<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EstudiantesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //obtener los estudiantes del año académico actual
        return Estudiante::join('estudiante_grado', function($join) {
                                            $join->on('estudiante_grado.estudiante_id', '=', 'estudiantes.id')
                                                ->where('estudiante_grado.year_id', '=', session('periodoAcademico'));
                                        })
                                        ->with(['grados' => function($query) {
                                            $query->where('estudiante_grado.year_id', '=', session('periodoAcademico'));
                                        }])
                                        ->with(['grupos' => function($query) {
                                            $query->where('estudiante_grupo.year_id', '=', session('periodoAcademico'));
                                        }])
                                        ->with('user:id,email')
                                        ->orderBy('grado_id')
                                        ->orderBy('apellidos')
                                        ->select('estudiantes.*')
                                        ->get();
    }

    public function map($estudiante): array
    {
        return [
            $estudiante->apellidos,
            $estudiante->nombres,            
            $estudiante->grados->first()->nombre,
            $estudiante->grupos->first() ? ucwords(strtolower($estudiante->grupos->first()->nombre)) : '',
            $estudiante->documento,
            $estudiante->fecha_nacimiento,
            $estudiante->genero,
            $estudiante->direccion,
            $estudiante->telefono,
            $estudiante->celular,
            $estudiante->user->email,
            $estudiante->grados->first()->pivot->estado_id,
            //$estudiante->grados->first()->pivot->estado_id == 1 ? 'Activo' : ($estudiante->grados->first()->pivot->estado_id == 2 ? 'Pendiente' : 'Retirado'),  //estados (1:activo, 2:pendiente, 3:retirado)
        ];
    }

    public function headings(): array
    {
        return [
            'Apellidos',
            'Nombres',
            'Grado',
            'Grupo',
            'Documento',
            'Fecha de Nacimiento',
            'Género',
            'Dirección',
            'Teléfono',
            'Celular',
            'Email',
            'Estado',
        ];
    }
}
