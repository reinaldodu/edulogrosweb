<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\Asignacion;
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
            'periodos' => Periodo::where('fecha_inicio', '<=', date('Y-m-d'))->get(),
            'grupos' => Grupo::orderBy('grado_id')->orderBy('nombre')->get(),
            'asignaturas' => Asignacion::join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
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
        $grupo = Grupo::find($request->grupo_id);
        $estudiantes = $grupo->estudiantes->pluck('id');
        //dd($grupo->estudiantes->pluck('id'));
        // Recorrer todos los estudiantes del grupo y guardar la asistencia
        foreach ($estudiantes as $estudiante) {
            // Verificar si el estudiante  existe en el arreglo de asistentes
            if (in_array($estudiante, $request->estudiantes)) {
                $tipo = 1;  // Presente
            } else {
                $tipo = 2; // Ausente
            }
            // Verificar si existe una asistencia del estudiante para actualizarla y evitar duplicados
            $asistencia = Asistencia::where('estudiante_id', $estudiante)
                                    ->where('asignatura_id', $request->asignatura_id)
                                    ->where('fecha', $request->fecha)
                                    ->first();
            if ($asistencia) {
                $asistencia->update([
                    'tipo' => $tipo,
                ]);
            } else {
                Asistencia::create([
                    'estudiante_id' => $estudiante,
                    'asignatura_id' => $request->asignatura_id,
                    'tipo' => $tipo,
                    'fecha' => $request->fecha,
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
        return Inertia::render('Admin/Asistencias/AsistenciaEstudiantes', [
            'hoy' => date('Y-m-d'),
            'estudiantes' => $grupo->estudiantes()->select('estudiantes.id', 'nombres', 'apellidos', 'fecha_nacimiento', 'foto')->get(),
            'checkStudent' => Asistencia::join('estudiantes', 'estudiantes.id', '=', 'asistencias.estudiante_id')
                                        ->where('asignatura_id', $asignatura->id)
                                        ->where('tipo', 1)                                        
                                        ->where('fecha', $fecha)
                                        ->get()->pluck('estudiante_id'),  //Array de estudiantes que asistieron a clase (tipo = 1)
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
