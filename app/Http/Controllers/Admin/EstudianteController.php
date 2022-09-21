<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Models\Estudiante;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Grado;
use App\Models\TipoDocumento;
use App\Models\Parentesco;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\EstudianteRequest;
use Illuminate\Support\Facades\Redis;
//Trabajar con Vue
use Inertia\Inertia;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        return Inertia::render('Admin/Estudiantes/ListarEstudiantes', [
            'estudiantes' => Estudiante::with('grado', 'pais', 'user')
                                        ->when($search, function ($query, $search) {
                                            $query->where('apellidos', 'like', '%' . $search . '%')
                                                ->orWhere('nombres', 'like', '%' . $search . '%');
                                        })
                                        ->orderBy('grado_id')
                                        ->orderBy('apellidos')
                                        ->paginate()->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Estudiantes/CrearEstudiante', [            
            'paises' => Pais::orderBy('nombre')->get(),
            'departamentos' => Departamento::orderBy('nombre')->get(),
            'municipios' => Municipio::orderBy('nombre')->get(),
            'grados' => Grado::all(),
            'tipo_documentos' => TipoDocumento::all(),
        ]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstudianteRequest $request)
    {
        //Crear el usuario antes de guardar el estudiante
        $user = User::create([
            'name' => $request->nombres,
            'email' => $request->email,
            'password' => bcrypt($request->documento),
            'rol_id' => 3,  //rol estudiante
        ]); 
        //Creamos el estudiante            
        $request->merge(['user_id' => $user->id]);   //Se agrega el user_id al request
        $estudiante = Estudiante::create($request->all());
        return redirect()->route('admin.estudiantes.show', $estudiante->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Estudiante $estudiante)    {        
        //Guardamos en un arreglo los ids de los acudientes del estudiante para saber más adelante los hermanos
        $acudientes_id = $estudiante->acudientes()->pluck('acudiente_id');
        
        return Inertia::render('Admin/Estudiantes/DatosEstudiante', [
            'estudiante' => Estudiante::with('grado', 'municipio_doc', 'municipio_nacimiento', 'pais', 'user')->find($estudiante->id),
            'paises' => Pais::orderBy('nombre')->get(),
            'departamentos' => Departamento::orderBy('nombre')->get(),
            'municipios' => Municipio::orderBy('nombre')->get(),
            'parentescos' => Parentesco::all(),
            'tipo_documentos' => TipoDocumento::all(),
            'acudientes' => $estudiante->acudientes()->with('parentesco', 'pais', 'user')->get(),
            'hermanos' => DB::table('acudiente_estudiante')
                                ->join('estudiantes', 'acudiente_estudiante.estudiante_id', '=', 'estudiantes.id')
                                ->select('estudiante_id', 'nombres', 'apellidos')
                                ->where('estudiante_id', '<>', $estudiante->id)
                                ->whereIn('acudiente_id', $acudientes_id)
                                ->distinct()
                                ->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiante $estudiante)
    {
        return Inertia::render('Admin/Estudiantes/EditarEstudiante', [
            'estudiante' => Estudiante::with('grado', 'municipio_doc', 'municipio_nacimiento', 'pais', 'user')->find($estudiante->id),
            'paises' => Pais::orderBy('nombre')->get(),
            'departamentos' => Departamento::orderBy('nombre')->get(),
            'municipios' => Municipio::orderBy('nombre')->get(),
            'grados' => Grado::all(),
            'tipo_documentos' => TipoDocumento::all(),            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function update(EstudianteRequest $request, Estudiante $estudiante)
    {        
       //actualizar el email y nombre en la tabla users
       $actualiza_user = DB::table('users')
       ->where('id', $request->user_id)
       ->update(['email' => $request->email, 'name' => $request->nombres]);

        $estudiante->update($request->all());
        return redirect()->route('admin.estudiantes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();
        return redirect()->route('admin.estudiantes.index');
    }
}
