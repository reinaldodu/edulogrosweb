<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotaLogro;
use App\Models\Logro;
use App\Models\ActividadLogro;
use App\Models\Asignatura;
use App\Models\Periodo;
use App\Models\EscalaValoracion;

use Illuminate\Http\Request;
use App\Http\Requests\NotaLogroRequest;

use Inertia\Inertia;

class NotaLogroController extends Controller
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
    public function store(NotaLogroRequest $request, Logro $logro, ActividadLogro $actividad)
    {
        //recorrer el array de notas y guardarlas
        foreach ($request->notas as $estudianteId => $nota) {
            //se verifica primero si ya existe una nota (logro o actividad) para el estudiante
            if($actividad) {
                $notaLogro = NotaLogro::where('estudiante_id', $estudianteId)
                                        ->where('logro_id', $logro->id)
                                        ->where('actividad_id', $actividad->id)
                                        ->where('year_id', session('periodoAcademico'))
                                        ->first();
            } else {
                $notaLogro = NotaLogro::where('estudiante_id', $estudianteId)
                                        ->where('logro_id', $logro->id)
                                        ->where('year_id', session('periodoAcademico'))
                                        ->first();
            }

            //*** VALIDACIONES ANTES DE GUARDAR LA NOTA */
            //si existe la nota se actualiza o elimina
            if($notaLogro) {
                //Si la nota es diferente a null se actualiza
                if ($nota) {
                    $notaLogro->update([
                        'estudiante_id' => $estudianteId,
                        'logro_id' => $logro->id,
                        'actividad_id' => $actividad->id,
                        'nota' => $nota,
                    ]);                    
                } else {  //si la nota es null se elimina
                    $notaLogro->delete();
                }
                
            } else {
                //si no existe la nota y es diferente a null se crea
                if ($nota) {
                    $notaLogro = NotaLogro::create([
                        'estudiante_id' => $estudianteId,
                        'logro_id' => $logro->id,
                        'actividad_id' => $actividad->id,
                        'nota' => $nota,
                        'year_id' => session('periodoAcademico'),
                    ]);
                }
            }
        }
        //regresar al panel de evaluacion del periodo, grupo y asignatura evaluado
        return redirect()->route('admin.panel-evaluaciones.show', [$logro->periodo_id, $logro->grupo_id, $logro->asignatura_id,]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotaLogro  $notaLogro
     * @return \Illuminate\Http\Response
     */
    public function show(Logro $logro, ActividadLogro $actividad=null)
    {
        // Verificar que la actividad pertenezca al logro
        if (($actividad) && (!$logro->actividadesLogros->firstWhere('id', $actividad->id))) {
            return abort(404);
        }

        //Verificar la escala de valoración del grado
        $verificar_escala_valoracion = EscalaValoracion::where('year_id', session('periodoAcademico'))
                                                        ->where('grado_id', $logro->grupo->grado_id)->get();
        if ($verificar_escala_valoracion->isEmpty()) {
            return redirect()->back()->with('message', 'No se ha creado una escala de valoración para el grado '. $logro->grupo->grado->nombre);
        } else {
            // obtener el valor mínimo y máximo de la escala de valoración
            $min = min($verificar_escala_valoracion->pluck('rango_inicial')->toArray());
            $max = max($verificar_escala_valoracion->pluck('rango_final')->toArray());            
        }

        $datos=[];
        $estudiantes = $logro->grupo->estudiantes()->select('estudiantes.id', 'nombres', 'apellidos', 'fecha_nacimiento')->get();
        // Recorrer la lista de estudiantes y obtener las notas del logro / actividad
        foreach ($estudiantes as $estudiante) {
            if ($actividad) {  // Si se evalua por actividades
                $nota = $estudiante->notasLogros()
                                    ->where('logro_id', $logro->id)
                                    ->where('actividad_id', $actividad->id)
                                    ->where('year_id', session('periodoAcademico'))
                                    ->first();
            } else {  //Si se evalua por logros
                $nota = $estudiante->notasLogros()
                                    ->where('logro_id', $logro->id)
                                    ->where('actividad_id', null)
                                    ->where('year_id', session('periodoAcademico'))
                                    ->first();
            }
            $nota = $nota ? $nota->nota : null;
            $datos[$estudiante->id]= $nota;
        }
        //dd($datos);
        return Inertia::render('Admin/Notas/VerNotasLogros', [
            'logro' => $logro,
            'actividad' => $actividad,
            'estudiantes' => $estudiantes,
            'asignatura' => Asignatura::find($logro->asignatura_id),
            'periodo' => Periodo::find($logro->periodo_id),
            'notas' => $datos,
            'rangoInicial' => $min,
            'rangoFinal' => $max,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotaLogro  $notaLogro
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaLogro $notaLogro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotaLogro  $notaLogro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaLogro $notaLogro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotaLogro  $notaLogro
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaLogro $notaLogro)
    {
        //
    }
}
