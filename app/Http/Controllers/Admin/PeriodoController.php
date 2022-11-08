<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodoRequest;

use Inertia\Inertia;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Periodos/ListarPeriodos', [
            'periodos' => Periodo::where('year_id', session('periodoAcademico'))
                                    ->withCount('logros', 'notasGenerales', 'actividadesGenerales')
                                    ->orderBy('fecha_inicio')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Periodos/CrearPeriodo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodoRequest $request)
    {
        //agregar el año academico al periodo
        $request->merge(['year_id' => session('periodoAcademico')]);
        $periodo = Periodo::create($request->all());
        return to_route('admin.periodos.index')->with('message', 'Periodo creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Periodo $periodo)
    {
        return Inertia::render('Admin/Periodos/EditarPeriodo', [
            'periodo' => $periodo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function update(PeriodoRequest $request, Periodo $periodo)
    {
        $periodo->update($request->all());
        return redirect()->route('admin.periodos.index')->with('message', 'Periodo actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periodo $periodo)
    {
        $periodo->delete();
        return redirect()->route('admin.periodos.index')->with('message', 'Periodo eliminado del sistema');
    }
}
