<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SistemaEvaluacion;
use App\Models\Grado;
use App\Models\TipoEvaluacion;
use Illuminate\Http\Request;

use App\Http\Requests\SistemaEvaluacionRequest;
use Inertia\Inertia;

class SistemaEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/SistemaEvaluacion/ListarSistemaEvaluacion', [
            'evaluaciones' => SistemaEvaluacion::with('grado', 'tipo_evaluacion')
                                                ->where('year_id', session('periodoAcademico'))
                                                ->orderBy('grado_id')
                                                ->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/SistemaEvaluacion/CrearSistemaEvaluacion', [
            'grados' => Grado::all(),
            'tipos' => TipoEvaluacion::where('year_id', session('periodoAcademico'))->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SistemaEvaluacionRequest $request)
    {
        //Recorremos el arreglo de los ids de grados ($request->grado_id) para guardar cada registro en la BD.
        foreach ($request->grado_id as $grado)
        {
            $evaluacion = SistemaEvaluacion::create([
                'grado_id' => $grado,
                'tipo_evaluacion_id' => $request->tipo_evaluacion_id,
                'porcentaje' => $request->porcentaje,
                'evalua_actividades' => $request->evalua_actividades,
                'year_id' => session('periodoAcademico'),
            ]);

        }
        return redirect()->route('admin.sistema-evaluacion.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SistemaEvaluacion  $sistemaEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function show(SistemaEvaluacion $sistemaEvaluacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SistemaEvaluacion  $sistemaEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function edit(SistemaEvaluacion $sistemaEvaluacion)
    {
        return Inertia::render('Admin/SistemaEvaluacion/EditarSistemaEvaluacion', [
            'evaluacion' => $sistemaEvaluacion,
            'grados' => Grado::all(),
            'tipos' => TipoEvaluacion::where('year_id', session('periodoAcademico'))->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SistemaEvaluacion  $sistemaEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function update(SistemaEvaluacionRequest $request, SistemaEvaluacion $sistemaEvaluacion)
    {
        $sistemaEvaluacion->update($request->all());
        return redirect()->route('admin.sistema-evaluacion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SistemaEvaluacion  $sistemaEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(SistemaEvaluacion $sistemaEvaluacion)
    {
        $sistemaEvaluacion->delete();
        return redirect()->route('admin.sistema-evaluacion.index');
    }
}
