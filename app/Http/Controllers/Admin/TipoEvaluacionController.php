<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoEvaluacion;
use Illuminate\Http\Request;

use App\Http\Requests\TipoEvaluacionRequest;
use Inertia\Inertia;

class TipoEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/SistemaEvaluacion/TiposEvaluacion/ListarTiposEvaluacion', [
            'tipos' => TipoEvaluacion::with('evaluaciones')
                                        ->where('year_id', session('periodoAcademico'))
                                        ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/SistemaEvaluacion/TiposEvaluacion/CrearTipoEvaluacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoEvaluacionRequest $request)
    {
        $tipoEvaluacion = TipoEvaluacion::create([
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura,
            'year_id' => session('periodoAcademico')
        ]);
        return redirect()->route('admin.tipo-evaluaciones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoEvaluacion  $tipoEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function show(TipoEvaluacion $tipoEvaluacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoEvaluacion  $tipoEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoEvaluacion $tipoEvaluacion)
    {
        return Inertia::render('Admin/SistemaEvaluacion/TiposEvaluacion/EditarTipoEvaluacion', [
            'tipo' => $tipoEvaluacion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoEvaluacion  $tipoEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function update(TipoEvaluacionRequest $request, TipoEvaluacion $tipoEvaluacion)
    {
        $tipoEvaluacion->update($request->all());
        return redirect()->route('admin.tipo-evaluaciones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoEvaluacion  $tipoEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoEvaluacion $tipoEvaluacion)
    {
        $tipoEvaluacion->delete();
        return redirect()->route('admin.tipo-evaluaciones.index');
    }
}
