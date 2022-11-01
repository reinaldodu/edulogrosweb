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
            //Obtener los estudiantes que tienen un grado asignado en el año académico actual
            'estudiantes' => Estudiante::join('estudiante_grado', function($join) {
                                            $join->on('estudiante_grado.estudiante_id', '=', 'estudiantes.id')
                                                ->where('estudiante_grado.year_id', '=', session('periodoAcademico'));
                                        })
                                        ->join('grados', 'grados.id', '=', 'estudiante_grado.grado_id')
                                        ->with('pais:id,nombre', 'user:id,email')
                                        ->when($search, function ($query, $search) {
                                            $query->where('apellidos', 'like', '%' . $search . '%')
                                                ->orWhere('nombres', 'like', '%' . $search . '%');
                                        })
                                        ->orderBy('grado_id')
                                        ->orderBy('apellidos')
                                        ->select(['estudiantes.id', 'nombres', 'apellidos', 'documento', 'fecha_nacimiento', 'pais_id', 'user_id', 'foto', 'grados.nombre as grado'])
                                        ->withExists(['grupos', 'notasLogros', 'notasGenerales', 'Observaciones'])
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
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->documento),
            'rol_id' => 3,  //rol estudiante
        ]); 
        //Creamos el estudiante            
        $request->merge(['user_id' => $user->id]);   //Se agrega el user_id al request
        $estudiante = Estudiante::create($request->except('grado_id')); // El grado_id no se guarda en la tabla estudiantes, se guarda en la tabla pivot estudiante_grado
        //Guardar el grado del estudiante en la tabla pivot estudiante_grado
        $estudiante->grados()->attach($request->grado_id, ['year_id' => session('periodoAcademico')]);
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
            'estudiante' => Estudiante::with(['grados' => function($query) {
                                            $query->where('year_id', '=', session('periodoAcademico'))->firstOrFail();
                                        }])->with('municipio_doc', 'municipio_nacimiento', 'pais', 'tipo_documento', 'user')->find($estudiante->id),
            'paises' => Pais::orderBy('nombre')->get(),
            'parentescos' => Parentesco::all(),
            'tipo_documentos' => TipoDocumento::all(),
            'acudientes' => $estudiante->acudientes()->with('parentesco', 'pais', 'tipo_documento', 'user')->get(),
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
            'estudiante' => Estudiante::with(['grados' => function($query) {
                $query->where('year_id', '=', session('periodoAcademico'))->firstOrFail();
            }])->with('municipio_doc', 'municipio_nacimiento', 'pais', 'user')->find($estudiante->id),
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
       //dd($request->all());
        //actualizar el email y nombre en la tabla users
       $user = User::find($estudiante->user_id);
       $user->update([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->email,
       ]);

        //Actualizar el estudiante 
        $estudiante->update($request->except('grado_id'));
        //Actualizar el grado en la tabla pivot
        $estudiante->grados()->updateExistingPivot($request->grado_old, ['grado_id' => $request->grado_id]);
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
        //buscar el usuario del estudiante a eliminar
        $user = User::find($estudiante->user_id);
        
        //eliminar los grados del estudiante
        $estudiante->grados()->detach();

        //eliminar el estudiante
        $estudiante->delete();
        
        //eliminar el usuario
        $user->delete();
        return redirect()->route('admin.estudiantes.index');
    }
}
