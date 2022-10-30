<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoAsistencia;
use Illuminate\Http\Request;
use App\Http\Requests\TipoAsistenciaRequest;

use Inertia\Inertia;

class TipoAsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = TipoAsistencia::withCount('asistencias')
                                        ->where('year_id', session('periodoAcademico'))
                                        ->get();
        //obtener el id del primer tipo de asistencia
        //$tipo_first = $tipos->first()->id;
        //obtener el id del último tipo de asistencia
        //$tipo_last = $tipos->last()->id;

        return Inertia::render('Admin/Asistencias/TipoAsistencias/ListarTipoAsistencia', [
            'tipos' => $tipos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Asistencias/TipoAsistencias/CrearTipoAsistencia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoAsistenciaRequest $request)
    {
        //contar los tipos de asistencia existentes para asignar el siguiente id
        $count = TipoAsistencia::count();
        TipoAsistencia::create([
            'id' => $count + 1,
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura,
            'color' => $request->color,
            'year_id' => session('periodoAcademico'),
        ]);
        return redirect()->route('admin.tipo-asistencias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoAsistencia  $tipoAsistencia
     * @return \Illuminate\Http\Response
     */
    public function show(TipoAsistencia $tipoAsistencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoAsistencia  $tipoAsistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoAsistencia $tipoAsistencia)
    {
        return Inertia::render('Admin/Asistencias/TipoAsistencias/EditarTipoAsistencia', [
            'tipo' => $tipoAsistencia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoAsistencia  $tipoAsistencia
     * @return \Illuminate\Http\Response
     */
    public function update(TipoAsistenciaRequest $request, TipoAsistencia $tipoAsistencia)
    {
        $tipoAsistencia->update($request->all());
        return redirect()->route('admin.tipo-asistencias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoAsistencia  $tipoAsistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoAsistencia $tipoAsistencia)
    {
        $tipoAsistencia->delete();
        return redirect()->route('admin.tipo-asistencias.index');
    }
}
