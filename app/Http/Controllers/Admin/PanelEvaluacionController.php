<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\Asignacion;
use App\Models\SistemaEvaluacion;
use App\Models\ActividadGeneral;
use App\Models\TipoEvaluacion;
use Inertia\Inertia;

class PanelEvaluacionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Notas/PanelEvaluaciones', [
            'periodos' => Periodo::where('year_id', session('periodoAcademico'))->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                                ->orderBy('grado_id')->orderBy('nombre')->get(),
            'asignaturas' => Asignacion::where('year_id', session('periodoAcademico'))
                                        ->join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
                                        ->get(),
            'selectores' => [
                'periodo' => '',
                'grupo' => '',
                'asignatura' => '',
            ],
        ]);
    }
    
    
    public function show(Periodo $periodo, Grupo $grupo, Asignatura $asignatura)
    {
        // Verificar que la asignatura pertenezca al grupo
        $asignacion = Asignacion::where('grupo_id', $grupo->id)
                                ->where('asignatura_id', $asignatura->id)
                                ->firstOrFail();
                                
        // Verificar el sistema de evaluación para el grupo
        $sistema_evaluacion = SistemaEvaluacion::with('tipo_evaluacion')
                                                ->where('grado_id', $grupo->grado_id)
                                                ->where('year_id', session('periodoAcademico'))
                                                ->get();
        $logros = $grupo->logros()->where('periodo_id', $periodo->id)
                                  ->where('year_id', session('periodoAcademico'))
                                  ->where('asignatura_id', $asignatura->id)
                                  ->with('actividadesLogros', 'notasLogros')->get();
        $estudiantes = $grupo->estudiantes()->with('notasLogros','notasGenerales')
                                            ->get(['estudiantes.id', 'fecha_nacimiento']);
        
        return Inertia::render('Admin/Notas/PanelEvaluaciones', [
            'periodos' => Periodo::where('year_id', session('periodoAcademico'))->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                                ->orderBy('grado_id')->orderBy('nombre')->get(),
            'asignaturas' => Asignacion::where('year_id', session('periodoAcademico'))
                                        ->join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
                                        ->get(),
            'evaluaciones' => $sistema_evaluacion,
            'id_tipo_logros' => TipoEvaluacion::where('year_id', session('periodoAcademico'))
                                                ->first()->id ?? null,  //Id del tipo de evaluación logros del año académico actual
            'logros' => $logros,
            'estudiantes' => $estudiantes,
            'actividades_generales' => ActividadGeneral::where('year_id', session('periodoAcademico'))
                                                        ->where('periodo_id', $periodo->id)
                                                        ->where('asignatura_id', $asignatura->id)
                                                        ->where('grupo_id', $grupo->id)
                                                        ->get(),
            'selectores' => [
                'periodo' => $periodo->id,
                'grupo' => $grupo->id,
                'asignatura' => $asignatura->id,
            ],

        ]);
    }
}
