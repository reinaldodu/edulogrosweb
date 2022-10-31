<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActividadLogro;
use Illuminate\Http\Request;
use App\Http\Requests\ActividadLogroRequest;

class ActividadLogroController extends Controller
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
    public function store(ActividadLogroRequest $request)
    {
        //dd($request->all());
        //agregar el año academico actual
        $request->merge(['year_id' => session('periodoAcademico')]);
        $actividad = ActividadLogro::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActividadLogro  $actividadLogro
     * @return \Illuminate\Http\Response
     */
    public function show(ActividadLogro $actividadLogro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActividadLogro  $actividadLogro
     * @return \Illuminate\Http\Response
     */
    public function edit(ActividadLogro $actividadLogro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActividadLogro  $actividadLogro
     * @return \Illuminate\Http\Response
     */
    public function update(ActividadLogroRequest $request, ActividadLogro $actividad)
    {
        $actividad->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActividadLogro  $actividadLogro
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActividadLogro $actividad)
    {
        $actividad->delete();
        return redirect()->back();
    }
}
