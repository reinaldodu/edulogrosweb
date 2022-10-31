<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EscalaValoracion;
use Illuminate\Http\Request;

use App\Http\Requests\EscalaValoracionRequest;
use App\Models\Grado;
use Inertia\Inertia;

class EscalaValoracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/SistemaEvaluacion/EscalaValoracion/ListarEscalaValoracion', [
            'escalas' => EscalaValoracion::with('grado')
                                            ->where('year_id', session('periodoAcademico'))
                                            ->orderBy('grado_id')
                                            ->orderBy('rango_inicial')
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
        return Inertia::render('Admin/SistemaEvaluacion/EscalaValoracion/CrearEscalaValoracion', [
            'grados' => Grado::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EscalaValoracionRequest $request)
    {
        //Recorremos el arreglo de los ids de grados ($request->grado_id) para guardar cada registro en la BD.
        foreach ($request->grado_id as $grado)
        {
            $valoracion = EscalaValoracion::create([
                'grado_id' => $grado,
                'nombre' => $request->nombre,
                'abreviatura' => $request->abreviatura,
                'rango_inicial' => $request->rango_inicial,
                'rango_final' => $request->rango_final,
                'year_id' => session('periodoAcademico'),
                //Si se selecciona una imagen se guarda en el disco
                'imagen' => $request->hasFile('imagen') ? $request->file('imagen')->store('images/evaluacion', 'public') : null,
            ]);

        }
        return redirect()->route('admin.escala-valoracion.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EscalaValoracion  $escalaValoracion
     * @return \Illuminate\Http\Response
     */
    public function show(EscalaValoracion $escalaValoracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EscalaValoracion  $escalaValoracion
     * @return \Illuminate\Http\Response
     */
    public function edit(EscalaValoracion $escalaValoracion)
    {
        return Inertia::render('Admin/SistemaEvaluacion/EscalaValoracion/EditarEscalaValoracion', [
            'escala' => $escalaValoracion,
            'grados' => Grado::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EscalaValoracion  $escalaValoracion
     * @return \Illuminate\Http\Response
     */
    public function update(EscalaValoracionRequest $request, EscalaValoracion $escalaValoracion)
    {
        
        //Si se selecciona una imagen se guarda sino no se modifica
        $escalaValoracion->update([
            'grado_id' => $request->grado_id,
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura,
            'rango_inicial' => $request->rango_inicial,
            'rango_final' => $request->rango_final,
            'imagen' => $request->hasFile('imagen') ? $request->file('imagen')->store('images/evaluacion', 'public') : $escalaValoracion->imagen,
        ]);
        
        //$escalaValoracion->update($request->all());
        return redirect()->route('admin.escala-valoracion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscalaValoracion  $escalaValoracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscalaValoracion $escalaValoracion)
    {
        $escalaValoracion->delete();
        return redirect()->route('admin.escala-valoracion.index');
    }
}
