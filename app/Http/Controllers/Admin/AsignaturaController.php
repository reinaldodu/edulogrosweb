<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
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
        // Se crea desde la vista de Edición del Área (EditarArea)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $request->validate([
            'nombre' => 'required'
        ]);
        // Se verifica que no se repita el nombre de la asignatura en la misma área
        $asignatura = Asignatura::where('nombre', $request->nombre)
                                ->where('area_id', $request->area_id)
                                ->exists();
        
        if ($asignatura) {
            return redirect()->back()->with('message', 'Ya existe una asignatura con el nombre ' . $request->nombre);
        } else {
            $asignatura = Asignatura::create($request->all());
            return back()->with('message', 'Asignatura agregada correctamente');
        }                
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asignatura  $asignatura
     * @return \Illuminate\Http\Response
     */
    public function show(Asignatura $asignatura)
    {
        // Se muestra desde la vista de Edición del Área (EditarArea)
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asignatura  $asignatura
     * @return \Illuminate\Http\Response
     */
    public function edit(Asignatura $asignatura)
    {
        // Se edita desde la vista de Edición del Área (EditarArea)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asignatura  $asignatura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        //Validar campo nombre que no esté en blanco
        $request->validate([
            'nombre' => 'required'
        ]);

        // Se verifica que no se repita el nombre de la asignatura en la misma área
        $verifica = Asignatura::where('nombre', $request->nombre)
                                ->where('id', '<>', $asignatura->id)
                                ->where('area_id', $asignatura->area_id)
                                ->exists();
        
        if ($verifica) {            
            return redirect()->back()->with('message', 'Ya existe una asignatura con el nombre ' . $request->nombre);
        } else {
            $asignatura->update($request->all());
            return back()->with('message', 'Asignatura actualizada correctamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asignatura  $asignatura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return back()->with('message', 'Asignatura eliminada correctamente');
    }
}
