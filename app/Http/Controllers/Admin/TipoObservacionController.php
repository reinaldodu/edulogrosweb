<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoObservacion;
use Illuminate\Http\Request;

use App\Http\Requests\TipoObservacionRequest;

use Inertia\Inertia;

class TipoObservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Observaciones/TipoObservaciones/ListarTipoObservacion', [
            'tipos' => TipoObservacion::where('year_id', session('periodoAcademico'))
                                        ->withCount('observaciones')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Observaciones/TipoObservaciones/CrearTipoObservacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoObservacionRequest $request)
    {
        $tipoObservacion = TipoObservacion::create([
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura,
            'year_id' => session('periodoAcademico'),
        ]);
        return redirect()->route('admin.tipo-observaciones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoObservacion  $tipo_observacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoObservacion  $tipo_observacion
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoObservacion $tipo_observacion)
    {
        return Inertia::render('Admin/Observaciones/TipoObservaciones/EditarTipoObservacion', [
            'tipo' => TipoObservacion::find($tipo_observacion->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoObservacion  $tipo_observacion
     * @return \Illuminate\Http\Response
     */
    public function update(TipoObservacionRequest $request, TipoObservacion $tipo_observacion)
    {
        $tipo_observacion->update($request->all());
        return redirect()->route('admin.tipo-observaciones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoObservacion  $tipo_observacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoObservacion $tipo_observacion)
    {
        $tipo_observacion->delete();
        return redirect()->route('admin.tipo-observaciones.index');
    }
}
