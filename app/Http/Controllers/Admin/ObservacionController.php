<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Observacion;
use App\Models\TipoObservacion;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\Asignacion;
use App\Models\ObservacionEstudiante;

use Illuminate\Http\Request;
use App\Http\Requests\ObservacionRequest;

use Inertia\Inertia;


class ObservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Observaciones/CrearObservaciones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObservacionRequest $request, $grupo, $asignatura)
    {
        //Si ha seleccionado el check para eliminar las observaciones y reemplazarlas por las que se van a pegar
        if($request->check_delete) {
            $delete = Observacion::where('year_id', session('periodoAcademico'))
                                    ->where('grupo_id', $grupo)
                                    ->where('asignatura_id', $asignatura)
                                    ->where('tipo_id', $request->tipo_id)
                                    ->delete();
        }
        
        //Se separan las observaciones por cada salto de linea (observaciones copiadas y pegadas)
        $observaciones = explode("\n", $request->observacion);

        foreach ($observaciones as $observacion)
        {
            $save = Observacion::create([
                'grupo_id' => $grupo,
                'asignatura_id' => $asignatura,
                'tipo_id' => $request->tipo_id,
                'observacion' => $observacion,
                'year_id' => session('periodoAcademico'),
            ]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo, Asignatura $asignatura)
    {
        return Inertia::render('Admin/Observaciones/ListarObservaciones', [
            'tipos' => TipoObservacion::where('year_id', session('periodoAcademico'))
                                        ->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                                ->orderBy('grado_id')
                                ->orderBy('nombre')
                                ->get(),
            'asignaturas' => Asignacion::join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
                                        ->get(),
            'observaciones' => Observacion::with('tipo', 'grupo', 'asignatura')
                                ->where('year_id', session('periodoAcademico'))
                                ->where('grupo_id', $grupo->id)
                                ->where('asignatura_id', $asignatura->id)
                                ->orderBy('tipo_id')
                                ->get(),
            //Para validar observaciones antes de eliminarlas (si existen observaciones de estudiantes no aparece el icono de eliminar)
            'observaciones_estudiantes' => ObservacionEstudiante::where('observacion_estudiantes.year_id', session('periodoAcademico'))
                                            ->join('observaciones', function($join) use ($grupo, $asignatura) {
                                                $join->on('observaciones.id', '=', 'observacion_estudiantes.observacion_id')
                                                    ->where('observaciones.grupo_id', '=', $grupo->id)
                                                    ->where('observaciones.asignatura_id', '=', $asignatura->id);
                                            })
                                            ->distinct()->get('observaciones.id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Observacion $observacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function update(ObservacionRequest $request, Observacion $observacion)
    {
        $observacion->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Observacion $observacion)
    {
        $observacion->delete();
        return redirect()->back();
    }
}
