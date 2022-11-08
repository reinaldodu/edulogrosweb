<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\Asignacion;
use App\Models\tipoAsistencia;

use Illuminate\Http\Request;
use App\Http\Requests\AsistenciaRequest;

use Inertia\Inertia;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Asistencias/ListarAsistencias', [
            'hoy' => date('Y-m-d'),
            'periodos' => Periodo::where('fecha_inicio', '<=', date('Y-m-d'))
                                  ->where('year_id', session('periodoAcademico'))
                                  ->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                              ->orderBy('grado_id')
                              ->orderBy('nombre')
                              ->get(),
            'asignaturas' => Asignacion::where('year_id', session('periodoAcademico'))
                                        ->join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
                                        ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsistenciaRequest $request)
    {
        foreach ($request->asistencias as $estudiante_id => $tipoAsistencia) {
            // Verificar si ya existe una asistencia del estudiante para actualizarla y evitar duplicados
            $asistencia = Asistencia::where('estudiante_id', $estudiante_id)
                                    ->where('asignatura_id', $request->asignatura_id)
                                    ->where('fecha', $request->fecha)
                                    ->where('year_id', session('periodoAcademico'))
                                    ->first();
            if ($asistencia) {
                $asistencia->update([
                    'tipo_id' => $tipoAsistencia,
                ]);
            } else {
                Asistencia::create([
                    'estudiante_id' => $estudiante_id,
                    'asignatura_id' => $request->asignatura_id,
                    'tipo_id' => $tipoAsistencia,
                    'fecha' => $request->fecha,
                    'year_id' => session('periodoAcademico'),
                ]);
            }
           
        }
        return redirect()->route('admin.asistencia.index')->with('message', 'Asistencia registrada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo, Grupo $grupo, Asignatura $asignatura, $fecha)
    {
        $estudiantes = $grupo->estudiantes()->select('estudiantes.id', 'nombres', 'apellidos', 'fecha_nacimiento', 'foto')->get();
        $asistencia=[];
        $tipoAsistencia = tipoAsistencia::where('year_id', session('periodoAcademico'))->get();
        //si tipoAsistencia esta vacio, envia un mensaje de error
        if ($tipoAsistencia->isEmpty()) {
            return to_route('admin.asistencia.index')->with('message', 'Debe crear primero tipos de asistencia, antes de registrar asistencias');
        }
        // Recorrer todos los estudiantes del grupo y verificar si tienen asistencia sino asignar por defecto el primer id = asiste
        foreach ($estudiantes as $estudiante) {
            $asistencia[$estudiante->id] = Asistencia::where('estudiante_id', $estudiante->id)
                                        ->where('asignatura_id', $asignatura->id)
                                        ->where('fecha', $fecha)
                                        ->where('year_id', session('periodoAcademico'))
                                        ->first()->tipo_id ?? $tipoAsistencia->first()->id;
        }
        return Inertia::render('Admin/Asistencias/AsistenciaEstudiantes', [
            'hoy' => date('Y-m-d'),
            'estudiantes' => $estudiantes,
            'asistencia' => $asistencia,
            'tipoAsistencia' => $tipoAsistencia,
            'data' => [
                'periodo' => $periodo,
                'grupo' => $grupo,
                'asignatura' => $asignatura,
                'fecha' => $fecha,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }
}
