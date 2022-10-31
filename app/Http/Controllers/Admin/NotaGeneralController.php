<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotaGeneral;
use App\Models\TipoEvaluacion;
use App\Models\Asignatura;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\ActividadGeneral;
use App\Models\EscalaValoracion;

use Illuminate\Http\Request;
use App\Http\Requests\NotaGeneralRequest;

use Inertia\Inertia;

class NotaGeneralController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotaGeneralRequest $request, TipoEvaluacion $tipo, Asignatura $asignatura, Periodo $periodo, Grupo $grupo, ActividadGeneral $actividad)
    {
        //recorrer el array de notas y guardarlas
        foreach ($request->notas as $estudianteId => $nota) {
            //se verifica primero si ya existe una nota (general o actividad) para el estudiante
            if($actividad) {
                $notaGeneral = NotaGeneral::where('estudiante_id', $estudianteId)
                                        ->where('tipo_evaluacion_id', $tipo->id)
                                        ->where('asignatura_id', $asignatura->id)
                                        ->where('periodo_id', $periodo->id)
                                        ->where('grupo_id', $grupo->id)
                                        ->where('actividad_id', $actividad->id)
                                        ->where('year_id', session('periodoAcademico'))
                                        ->first();
            } else {
                $notaGeneral = NotaGeneral::where('estudiante_id', $estudianteId)
                                        ->where('tipo_evaluacion_id', $tipo->id)
                                        ->where('asignatura_id', $asignatura->id)
                                        ->where('periodo_id', $periodo->id)
                                        ->where('grupo_id', $grupo->id)
                                        ->where('year_id', session('periodoAcademico'))
                                        ->first();
            }

            //*** VALIDACIONES ANTES DE GUARDAR LA NOTA */
            //si existe la nota se actualiza o elimina
            if($notaGeneral) {
                //Si la nota es diferente a null se actualiza
                if ($nota) {
                    $notaGeneral->update([
                        'estudiante_id' => $estudianteId,
                        'tipo_evaluacion_id' => $tipo->id,
                        'asignatura_id' => $asignatura->id,
                        'periodo_id' => $periodo->id,
                        'grupo_id' => $grupo->id,
                        'actividad_id' => $actividad->id,
                        'nota' => $nota,
                    ]);                    
                } else {  //si la nota es null se elimina
                    $notaGeneral->delete();
                }
                
            } else {
                //si no existe la nota y es diferente a null se crea
                if ($nota) {
                    $notaLogro = NotaGeneral::create([
                        'estudiante_id' => $estudianteId,
                        'tipo_evaluacion_id' => $tipo->id,
                        'asignatura_id' => $asignatura->id,
                        'periodo_id' => $periodo->id,
                        'grupo_id' => $grupo->id,
                        'actividad_id' => $actividad->id,
                        'nota' => $nota,
                        'year_id' => session('periodoAcademico'),
                    ]);
                }
            }

        }
        //regresar al panel de evaluacion del periodo, grupo y asignatura evaluado
        return redirect()->route('admin.panel-evaluaciones.show', [$periodo->id, $grupo->id, $asignatura->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotaGeneral  $notaGeneral
     * @return \Illuminate\Http\Response
     */
    public function show(TipoEvaluacion $tipo, Asignatura $asignatura, Periodo $periodo, Grupo $grupo, ActividadGeneral $actividad=null)
    {
        
        // Investigar algún método para ocultar los parámetros en la url

        // Verificar que la actividad pertenezca al tipo de evaluacion, al periodo, la asignatura y al grupo
        // if($actividad) {
        //     $verifica = ActividadGeneral::where('id', $actividad->id)
        //                                 ->where('tipo_evaluacion_id', $tipo->id)
        //                                 ->where('asignatura_id', $asignatura->id)
        //                                 ->where('periodo_id', $periodo->id)
        //                                 ->where('grupo_id', $grupo->id)
        //                                 ->first();
        //     if(!$verifica) {
        //         return abort(404);
        //     }
        // }

        // if (($actividad) && (!$logro->actividadesLogros->firstWhere('id', $actividad->id))) {
        //     return abort(404);
        // }

        //Verificar la escala de valoración del grado
        $verificar_escala_valoracion = EscalaValoracion::where('year_id', session('periodoAcademico'))
                                                        ->where('grado_id', $grupo->grado_id)->get();
        if ($verificar_escala_valoracion->isEmpty()) {
            return redirect()->back()->with('message', 'No se ha creado una escala de valoración para el grado '. $grupo->grado->nombre);
        } else {
            // obtener el valor mínimo y máximo de la escala de valoración
            $min = min($verificar_escala_valoracion->pluck('rango_inicial')->toArray());
            $max = max($verificar_escala_valoracion->pluck('rango_final')->toArray());
        }

        $datos=[];
        $estudiantes = $grupo->estudiantes()->select('estudiantes.id', 'nombres', 'apellidos', 'fecha_nacimiento')->get();
        // Recorrer la lista de estudiantes y obtener las notas generales / actividad_general
        foreach ($estudiantes as $estudiante) {
            if ($actividad) {  // Si se evalua por actividades
                $nota = $estudiante->notasGenerales()->where('tipo_evaluacion_id', $tipo->id)
                                                     ->where('asignatura_id', $asignatura->id)
                                                     ->where('periodo_id', $periodo->id)
                                                     ->where('grupo_id', $grupo->id)
                                                     ->where('actividad_id', $actividad->id)
                                                     ->where('year_id', session('periodoAcademico'))
                                                     ->first();

            } else {  //Si se evalua por notas generales
                $nota = $estudiante->notasGenerales()->where('tipo_evaluacion_id', $tipo->id)
                                                     ->where('asignatura_id', $asignatura->id)
                                                     ->where('periodo_id', $periodo->id)
                                                     ->where('grupo_id', $grupo->id)
                                                     ->where('actividad_id', null)
                                                     ->where('year_id', session('periodoAcademico'))
                                                     ->first();
            }
            $nota = $nota ? $nota->nota : null;
            $datos[$estudiante->id]= $nota;
        }
        //dd($datos);
        return Inertia::render('Admin/Notas/VerNotasGenerales', [
            'tipo' => $tipo,
            'asignatura' => $asignatura,
            'periodo' => $periodo,
            'grupo' => $grupo,
            'actividad' => $actividad,
            'estudiantes' => $estudiantes,
            'notas' => $datos,
            'rangoInicial' => $min,
            'rangoFinal' => $max,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotaGeneral  $notaGeneral
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaGeneral $notaGeneral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotaGeneral  $notaGeneral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaGeneral $notaGeneral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotaGeneral  $notaGeneral
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaGeneral $notaGeneral)
    {
        //
    }
}
