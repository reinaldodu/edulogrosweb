<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\SistemaEvaluacion;
use App\Models\ActividadGeneral;
use Inertia\Inertia;

class PanelEvaluacionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Notas/PanelEvaluaciones', [
            'periodos' => Periodo::all(),
            'grupos' => Grupo::orderBy('grado_id')->orderBy('nombre')->get(),
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
        if (!$grupo->asignaturas->firstWhere('id', $asignatura->id)) {
            return abort(404);
        }
        
        // Verificar el sistema de evaluación para el grupo
        $sistema_evaluacion = SistemaEvaluacion::with('tipo_evaluacion')->where('grado_id', $grupo->grado_id)->get();
        $logros = $grupo->logros()->where('periodo_id', $periodo->id)->where('asignatura_id', $asignatura->id)->with('actividadesLogros', 'notasLogros')->get();
        $estudiantes = $grupo->estudiantes()->with('notasLogros','notasGenerales')->get(['estudiantes.id', 'fecha_nacimiento']);
        
        return Inertia::render('Admin/Notas/PanelEvaluaciones', [
            'periodos' => Periodo::all(),
            'grupos' => Grupo::orderBy('grado_id')->orderBy('nombre')->get(),
            'asignaturas' => $grupo->asignaturas,
            'evaluaciones' => $sistema_evaluacion,
            'logros' => $logros,
            'estudiantes' => $estudiantes,
            'actividades_generales' => ActividadGeneral::where('periodo_id', $periodo->id)
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
