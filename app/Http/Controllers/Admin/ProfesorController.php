<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Models\Profesor;
use App\Models\User;
use App\Models\Pais;
use App\Models\TipoDocumento;

use Illuminate\Http\Request;

use App\Http\Requests\ProfesorRequest;

use Inertia\Inertia;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Profesores/ListarProfesores', [
            'profesores' => Profesor::with('user')
                                    ->select(['id', 'nombres', 'apellidos', 'documento', 'cargo', 'fecha_nacimiento', 'profesion', 'user_id', 'foto'])
                                    ->withCount('grupoDirector', 'grupoCodirector', 'asignaciones')
                                    ->orderBy('apellidos')->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Profesores/CrearProfesor', [            
            'paises' => Pais::orderBy('nombre')->get(),            
            'tipo_documentos' => TipoDocumento::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfesorRequest $request)
    {
        //Crear el usuario antes de guardar el acudiente
        $user = User::create([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->documento),
            'rol_id' => 5, //Rol profesor
        ]); 
       
        //Creamos el Profesor
        $request->merge(['user_id' => $user->id]);   //Se agrega el user_id al request
        $profesor = Profesor::create($request->all());
        return redirect()->route('admin.profesores.index');
        //return redirect()->back()->with('message', 'Profesor creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function show(Profesor $profesor)
    {
        return Inertia::render('Admin/Profesores/VerProfesor', [
            'profesor' => Profesor::with('pais', 'tipo_documento', 'user')->find($profesor->id),
            'paises' => Pais::orderBy('nombre')->get(),
            'tipo_documentos' => TipoDocumento::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function edit(Profesor $profesor)
    {
        return Inertia::render('Admin/Profesores/EditarProfesor', [
            'profesor' => Profesor::with('pais', 'user')->find($profesor->id),
            'paises' => Pais::orderBy('nombre')->get(),            
            'tipo_documentos' => TipoDocumento::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function update(ProfesorRequest $request, Profesor $profesor)
    {
        //actualizar el email y nombre en la tabla users
        $user = User::find($profesor->user_id);
        $user->update([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->email,
        ]);
        
        //Actualizar el profesor
        $profesor->update($request->all());
        return redirect()->route('admin.profesores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesor $profesor)
    {
        $profesor->delete();
        return redirect()->route('admin.profesores.index');
    }
}
