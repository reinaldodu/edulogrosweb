<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\Profesor;

use Illuminate\Http\Request;
use App\Http\Requests\GrupoRequest;

use Inertia\Inertia;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Grupos/ListarGrupos', [
            'grupos' => Grupo::with('grado', 'director', 'codirector', 'estudiantes', 'asignaciones')
                                ->orderBy('grado_id')
                                ->orderBy('nombre')
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
        return Inertia::render('Admin/Grupos/CrearGrupo', [
            'grados' => Grado::orderBy('id')->get(),
            'profesores' => Profesor::orderBy('apellidos')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoRequest $request)
    {
        $grupo = Grupo::create($request->all());
        return redirect()->route('admin.grupos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {       
        return Inertia::render('Admin/Grupos/VerGrupo', [
            'grupo' => Grupo::with('grado', 'director', 'codirector', 'estudiantes')
                                ->find($grupo->id),

            //Estudiantes disponibles por grado
            'disponibles' => Estudiante::where('grado_id', $grupo->grado_id)
                                        ->whereDoesntHave('grupos', function($query) use ($grupo) {
                                            $query->where('grado_id', $grupo->grado_id);
                                        })
                                        ->select('id', 'nombres', 'apellidos', 'foto', 'fecha_nacimiento')
                                        ->orderBy('apellidos')
                                        ->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        return Inertia::render('Admin/Grupos/EditarGrupo', [
            'grupo' => Grupo::with('estudiantes')->find($grupo->id),
            'grados' => Grado::orderBy('id')->get(),
            'profesores' => Profesor::orderBy('apellidos')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRequest $request, Grupo $grupo)
    {
        $grupo->update($request->all());
        return redirect()->route('admin.grupos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('admin.grupos.index')->with('message', 'Grupo eliminado correctamente');
    }

    public function agregarEstudianteGrupo(Request $request)
    {
        $request->validate([
            'estudiante' => 'required'
        ]);        
        $grupo = Grupo::find($request->id);
        $grupo->estudiantes()->attach($request->estudiante);
        return redirect()->route('admin.grupos.show', $grupo->id);
    }

    public function eliminarEstudianteGrupo(Grupo $grupo, Estudiante $estudiante)
    {              
        $grupo->estudiantes()->detach($estudiante->id);
        return redirect()->route('admin.grupos.show', $grupo->id);
    }             
     
}
