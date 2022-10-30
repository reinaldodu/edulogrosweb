<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObservacionEstudiante;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\Asignacion;
use App\Models\Observacion;
use Illuminate\Http\Request;
use App\Http\Requests\ObservacionEstudianteRequest;

use Inertia\Inertia;

class ObservacionEstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Observaciones/ObservacionesEstudiantes/ListarObservacionesEstudiantes', [
            'periodos' => Periodo::where('year_id', session('periodoAcademico'))
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
    public function store(ObservacionEstudianteRequest $request)
    {
        //dd($request->all());
        //recorremos el array de estudiantes
        foreach ($request->estudiantes as $estudiante) {
            //recorremos el array de observaciones
            foreach ($request->observaciones as $observacion) {
                //validar que la observacion no exista para el estudiante
                $observacion_estudiante = ObservacionEstudiante::where('year_id', session('periodoAcademico'))
                                                                ->where('estudiante_id', $estudiante)
                                                                ->where('observacion_id', $observacion)
                                                                ->where('periodo_id', $request->periodo)
                                                                ->first();
                if (!$observacion_estudiante) {
                    $observacionEstudiante = ObservacionEstudiante::create([
                        'estudiante_id' => $estudiante,
                        'observacion_id' => $observacion,
                        'periodo_id' => $request->periodo,
                        'year_id' => session('periodoAcademico'),
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObservacionEstudiante  $observacionEstudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo, Grupo $grupo, Asignatura $asignatura)
    {
        return Inertia::render('Admin/Observaciones/ObservacionesEstudiantes/ListarObservacionesEstudiantes', [
            'periodos' => Periodo::where('year_id', session('periodoAcademico'))
                                  ->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                                ->orderBy('grado_id')->orderBy('nombre')->get(),
            'asignaturas' => Asignacion::where('year_id', session('periodoAcademico'))
                                        ->join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
                                        ->get(),
            'observaciones' => Observacion::with('tipo')
                                            ->where('year_id', session('periodoAcademico'))
                                            ->where('grupo_id', $grupo->id)
                                            ->where('asignatura_id', $asignatura->id)
                                            ->get(),
            'estudiantes' => $grupo->estudiantes()->with(['observaciones' => function($query) use ($periodo, $asignatura, $grupo) {
                                                        $query->where('periodo_id', $periodo->id)
                                                              ->join('observaciones', function($join) use ($asignatura, $grupo) {
                                                                    $join->on('observaciones.id', '=', 'observacion_estudiantes.observacion_id')
                                                                        ->where('observaciones.asignatura_id', $asignatura->id)
                                                                        ->where('observaciones.grupo_id', $grupo->id)
                                                                        ->where('observaciones.year_id', session('periodoAcademico'));
                                                        });
                            }])->get(['estudiantes.id', 'estudiantes.nombres', 'estudiantes.apellidos', 'estudiantes.fecha_nacimiento', 'estudiantes.foto']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObservacionEstudiante  $observacionEstudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(ObservacionEstudiante $observacionEstudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObservacionEstudiante  $observacionEstudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ObservacionEstudiante $observacionEstudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObservacionEstudiante  $observacionEstudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy($estudiante, $observacion, $periodo)
    {
        $observacionEstudiante = ObservacionEstudiante::where('estudiante_id', $estudiante)
                                                        ->where('observacion_id', $observacion)
                                                        ->where('periodo_id', $periodo)
                                                        ->where('year_id', session('periodoAcademico'))
                                                        ->first();
        $observacionEstudiante->delete();
        return redirect()->back();
    }
}
