<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Observacion;
use App\Models\TipoObservacion;
use App\Models\Grado;
use App\Models\Asignatura;

use Illuminate\Http\Request;
use App\Http\Requests\ObservacionRequest;

use Inertia\Inertia;


class ObservacionController extends Controller
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
        return Inertia::render('Admin/Observaciones/CrearObservaciones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObservacionRequest $request, $grado, $asignatura)
    {
        //Si ha seleccionado el check para eliminar las observaciones y reemplazarlas por las que se van a pegar
        if($request->check_delete) {
            $delete = Observacion::where('grado_id', $grado)
                                    ->where('asignatura_id', $asignatura)
                                    ->where('tipo_id', $request->tipo_id)
                                    ->delete();
        }
        
        //Se separan las observaciones por cada salto de linea (observaciones copiadas y pegadas)
        $observaciones = explode("\n", $request->observacion);

        foreach ($observaciones as $observacion)
        {
            $save = Observacion::create([
                'grado_id' => $grado,
                'asignatura_id' => $asignatura,
                'tipo_id' => $request->tipo_id,
                'observacion' => $observacion,
            ]);
        }

        // $request->merge(['grado_id' => $grado]);
        // $request->merge(['asignatura_id' => $asignatura]);
        // $observacion = Observacion::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function show(Grado $grado, Asignatura $asignatura)
    {
        return Inertia::render('Admin/Observaciones/ListarObservaciones', [
            'tipos' => TipoObservacion::all(),
            'grados' => Grado::all(),
            'asignaturas' => Asignatura::all(),
            'observaciones' => Observacion::with('tipo', 'grado', 'asignatura')
                                ->where('grado_id', $grado->id)
                                ->where('asignatura_id', $asignatura->id)
                                ->orderBy('tipo_id')
                                ->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Observacion $observacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function update(ObservacionRequest $request, Observacion $observacion)
    {
        $observacion->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observacion  $observacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Observacion $observacion)
    {
        $observacion->delete();
        return redirect()->back();
    }
}
