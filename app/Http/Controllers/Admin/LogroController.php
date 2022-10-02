<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Logro;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\Asignatura;
use App\Models\Asignacion;

use Illuminate\Http\Request;
use App\Http\Requests\LogroRequest;

use Inertia\Inertia;

class LogroController extends Controller
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
        return Inertia::render('Admin/Logros/CrearLogros');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogroRequest $request, $periodo, $grupo, $asignatura)
    {                
        $request->merge(['periodo_id' => $periodo]);
        $request->merge(['grupo_id' => $grupo]);
        $request->merge(['asignatura_id' => $asignatura]);
        $logro = Logro::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logro  $logro
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo, Grupo $grupo, Asignatura $asignatura)
    {
        return Inertia::render('Admin/Logros/ListarLogros', [
            'periodos' => Periodo::all(),
            'grupos' => Grupo::orderBy('grado_id')->orderBy('nombre')->get(),
            'logros' => Logro::withCount('notasLogros', 'actividadesLogros')
                                ->where('periodo_id', $periodo->id)
                                ->where('grupo_id', $grupo->id)
                                ->where('asignatura_id', $asignatura->id)
                                ->get(),
            'asignaturas' => Asignacion::join('asignaturas', 'asignaturas.id', '=', 'asignaciones.asignatura_id')
                                        ->get(),
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logro  $logro
     * @return \Illuminate\Http\Response
     */
    public function edit(Logro $logro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logro  $logro
     * @return \Illuminate\Http\Response
     */
    public function update(LogroRequest $request, Logro $logro)
    {
        $logro->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logro  $logro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logro $logro)
    {
        $logro->delete();
        return redirect()->back();
    }
}
