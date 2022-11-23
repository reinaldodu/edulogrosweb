<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Exports\EstudiantesExport;

use App\Models\Estudiante;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Grado;
use App\Models\TipoDocumento;
use App\Models\Parentesco;
use App\Models\Estado;
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
    public function index()
    {
        $search = request()->input('search');
        return Inertia::render('Admin/Estudiantes/ListarEstudiantes', [
            //Obtener los estudiantes que tienen un grado asignado en el año académico actual
            'estudiantes' => Estudiante::join('estudiante_grado', function($join) {
                                            $join->on('estudiante_grado.estudiante_id', '=', 'estudiantes.id')
                                                ->where('estudiante_grado.year_id', '=', session('periodoAcademico'));
                                        })
                                        ->with(['grados' => function($query) {
                                            $query->where('estudiante_grado.year_id', '=', session('periodoAcademico'));
                                        }])
                                        ->with(['grupos' => function($query) {
                                            $query->where('estudiante_grupo.year_id', '=', session('periodoAcademico'));
                                        }])
                                        ->with('pais:id,nombre', 'user:id,email')
                                        ->when($search, function ($query, $search) {
                                            $query->where('apellidos', 'like', '%' . $search . '%')
                                                ->orWhere('nombres', 'like', '%' . $search . '%');
                                        })
                                        ->orderBy('grado_id')
                                        ->orderBy('apellidos')
                                        ->select(['estudiantes.id', 'nombres', 'apellidos', 'documento', 'fecha_nacimiento', 'pais_id', 'user_id', 'foto'])
                                        ->withExists(['grupos', 'notasLogros', 'notasGenerales', 'Observaciones', 'asistencias'])
                                        ->paginate()->withQueryString(),
            'estados' => Estado::all(),
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
        //Guardar el grado y el estado(2 - pendiente) del estudiante en la tabla pivot estudiante_grado
        $estudiante->grados()->attach($request->grado_id, ['year_id' => session('periodoAcademico'), 'estado_id' => 2]);
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
        $user_estudiante = User::find($estudiante->user_id);
        //buscar los acudientes del estudiante, si los acudientes tienen más de un estudiante a cargo, no se elimina el acudiente
        $acudientes = $estudiante->acudientes()->get();
        foreach ($acudientes as $acudiente) {
            if ($acudiente->estudiantes()->count() == 1) {
                //buscar el usuario del acudiente
                $user_acudiente = User::find($acudiente->user_id);
                //eliminar el acudiente
                $acudiente->delete();
                //eliminar el usuario del acudiente
                $user_acudiente->delete();
            }
        }
        //eliminar el grado del estudiante de la tabla pivot estudiante_grado
        $estudiante->grados()->detach();
        //eliminar el estudiante
        $estudiante->delete();
        //eliminar el usuario del estudiante
        $user_estudiante->delete();
        return redirect()->route('admin.estudiantes.index');
    }

    // Método para obtener los datos de un estudiante a través de su número de documento
    public function document($documento)
    {
        return $estudiante = Estudiante::where('documento', $documento)
                                        ->with(['grados' => function($query) {
                                            $query->where('year_id', '=', session('periodoAcademico'));
                                        }])
                                        ->first();
    }
    /* Método para agregar un estudiante (en la tabla pivote estudiante_grado) 
     que ya existe en la base de datos pero que no está en el año académico actual */
    public function agregarEstudianteExistente(Request $request)
    {        
        //validar $request->grado_id
        $request->validate([
            'grado_id' => 'required',
        ]);
        $estudiante = Estudiante::find($request->estudiante_id);
        if ($estudiante) {
                //Guardamos los valores en la tabla pivote estudiante_grado
                $estudiante->grados()->attach($request->grado_id, ['year_id' => session('periodoAcademico'), 'estado_id' => 2]);
                return to_route('admin.estudiantes.index')->with('message', 'Estudiante agregado correctamente');  //to_route = redirect()->route
        }
    }

    public function exportarExcel(EstudiantesExport $estudiantesExport)
    {
        return $estudiantesExport->download('estudiantes.xlsx');
    }
}
