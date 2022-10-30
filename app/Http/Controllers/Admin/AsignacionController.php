<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Asignacion;
use App\Models\Grupo;
use App\Models\Profesor;
use App\Models\Asignatura;

use Illuminate\Http\Request;
use App\Http\Requests\AsignacionRequest;

use Inertia\Inertia;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/AsignacionAcademica/ListarAsignacion', [
            
            'asignaciones' => Asignacion::with('grupo', 'profesor', 'asignatura')                                                    
                                                    ->where('asignaciones.year_id', session('periodoAcademico'))
                                                    ->join('grupos', 'grupos.id', '=', 'asignaciones.grupo_id')
                                                    ->join('grados', 'grados.id', '=', 'grupos.grado_id')
                                                    ->select('asignaciones.*', 'grados.nombre as grado_nombre')
                                                    ->orderBy('grupos.grado_id')
                                                    ->orderBy('grupos.nombre')
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
        return Inertia::render('Admin/AsignacionAcademica/CrearAsignacion', [
            'asignaturas' => Asignatura::orderBy('nombre')->get(),
            'profesores' => Profesor::orderBy('apellidos')->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                             ->orderBy('grado_id')
                             ->orderBy('nombre')
                             ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsignacionRequest $request)
    {
        //***VALIDAR DATOS***
        //Verificar que no exista una asignación igual para el profesor-asignatura-grupo
        foreach ($request->grupo_id as $grupo) {
            $verificar_asignacion = Asignacion::with('asignatura', 'profesor', 'grupo')
                                              ->where('profesor_id', $request->profesor_id)
                                              ->where('asignatura_id', $request->asignatura_id)
                                              ->where('grupo_id', $grupo)
                                              ->where('year_id', session('periodoAcademico'))
                                              ->first();
            if ($verificar_asignacion) {
                return redirect()->route('admin.asignaciones.create')->with('message', 'Ya existe la asignatura '. $verificar_asignacion->asignatura->nombre . ' del profesor '. $verificar_asignacion->profesor->nombres .' para el grupo '. $verificar_asignacion->grupo->nombre);
            }
        }
        
        //**GUARDAR DATOS***
        //Recorremos el arreglo de los ids de grupos ($request->grupo_id) para guardar cada registro en la BD.
        foreach ($request->grupo_id as $grupo)
        {
            $asignacion = Asignacion::create([
                'profesor_id' => $request->profesor_id,
                'asignatura_id' => $request->asignatura_id,
                'intensidad_horaria' => $request->intensidad_horaria,
                'grupo_id' => $grupo,
                'year_id' => session('periodoAcademico'),
            ]);

        }
        return redirect()->route('admin.asignaciones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function show(Asignacion $asignacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Asignacion $asignacion)
    {
        return Inertia::render('Admin/AsignacionAcademica/EditarAsignacion', [
            'asignacion' => $asignacion,
            'asignaturas' => Asignatura::orderBy('nombre')->get(),
            'profesores' => Profesor::orderBy('apellidos')->get(),
            'grupos' => Grupo::where('year_id', session('periodoAcademico'))
                            ->orderBy('grado_id')
                            ->orderBy('nombre')
                            ->get(),
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */

     public function update(AsignacionRequest $request, Asignacion $asignacion)
    {
        //Verificar que no exista una asignación igual para el profesor-asignatura-grupo
        $verificar_asignacion = Asignacion::with('asignatura', 'profesor', 'grupo')
                                            ->where('profesor_id', $request->profesor_id)
                                            ->where('asignatura_id', $request->asignatura_id)
                                            ->where('grupo_id', $request->grupo_id)
                                            ->where('year_id', session('periodoAcademico'))
                                            ->first();

        //verificar que no exista una asignación igual para el profesor-asignatura-grupo al editar
        if ($verificar_asignacion && $verificar_asignacion->id != $asignacion->id) {
            return redirect()->route('admin.asignaciones.edit', $asignacion)->with('message', 'Ya existe la asignatura '. $verificar_asignacion->asignatura->nombre . ' del profesor '. $verificar_asignacion->profesor->nombres .' para el grupo '. $verificar_asignacion->grupo->nombre);
        }
        
        //****ACTUALIZAR DATOS***
        $asignacion->update($request->all());
        return redirect()->route('admin.asignaciones.index');
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    
     public function destroy(Asignacion $asignacion)
    {
        $asignacion->delete();
        return redirect()->route('admin.asignaciones.index');
    }
}
