<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActividadGeneral;
use Illuminate\Http\Request;
use App\Http\Requests\ActividadGeneralRequest;

class ActividadGeneralController extends Controller
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
    public function store(ActividadGeneralRequest $request)
    {
        //dd($request->all());
        //agregar el año academico actual
        $request->merge(['year_id' => session('periodoAcademico')]);
        $actividad = ActividadGeneral::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActividadGeneral  $ActividadGeneral
     * @return \Illuminate\Http\Response
     */
    public function show(ActividadGeneral $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActividadGeneral  $ActividadGeneral
     * @return \Illuminate\Http\Response
     */
    public function edit(ActividadGeneral $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActividadGeneral  $ActividadGeneral
     * @return \Illuminate\Http\Response
     */
    public function update(ActividadGeneralRequest $request, ActividadGeneral $actividad)
    {
        $actividad->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActividadGeneral  $ActividadGeneral
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActividadGeneral $actividad)
    {
        $actividad->delete();
        return redirect()->back();
    }
}
