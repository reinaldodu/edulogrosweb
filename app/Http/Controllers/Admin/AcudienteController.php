<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Parentesco;
use App\Models\TipoDocumento;

use Illuminate\Support\Facades\DB;

use App\Models\Acudiente;
use Illuminate\Http\Request;

use App\Http\Requests\AcudienteRequest;

class AcudienteController extends Controller
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
        // Se muestra el formulario para crear el acudiente desde la vista VerEstudiante
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcudienteRequest $request)
    {    
        //Crear el acudiente si no existe en la base de datos
        $acudiente = Acudiente::where('documento', $request->documento)->first();
        if (!$acudiente) {

            //Crear el usuario antes de guardar el acudiente
            $user = User::create([
                'name' => $request->nombres . ' ' . $request->apellidos,
                'email' => $request->email,
                'password' => bcrypt($request->documento),
                'rol_id' => 4,  //rol acudiente
            ]); 
           
            //Creamos el acudiente            
            $request->merge(['user_id' => $user->id]);   //Se agrega el user_id al request
            $acudiente = Acudiente::create($request->all());
        }
        
        //Verificamos que en la tabla pivote no exista el mismo acudiente para un estudiante
        $existe_estudiante = $acudiente->estudiantes->contains($request->estudianteId);
        if (!$existe_estudiante) {
            //Guardamos las claves en la tabla pivote
            $acudiente->estudiantes()->attach($request->estudianteId);
            return redirect()->back()->with('message', 'Acudiente asignado correctamente');
        }
        else {
            return redirect()->back()->with('message', 'Acudiente ya existe en la lista');
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acudiente  $acudiente
     * @return \Illuminate\Http\Response
     */
    public function show(Acudiente $acudiente)
    {
        // Se muestran los acudientes desde la vista de DatosEstudiantes
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acudiente  $acudiente
     * @return \Illuminate\Http\Response
     */
    public function edit(Acudiente $acudiente)
    {
        // Se genera el formulario para editar el acudiente desde la vista DatosEstudiante
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acudiente  $acudiente
     * @return \Illuminate\Http\Response
     */
    public function update(AcudienteRequest $request, Acudiente $acudiente)
    {        
        //actualizar el email y nombre en la tabla users
        $user = User::find($acudiente->user_id);
        $user->update([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->email,
        ]);
        
        //actualizar el acudiente
        $acudiente->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acudiente  $acudiente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acudiente $acudiente)
    {        
        // Eliminar acudiente; si tiene mas de un estudiante a cargo solo se elimina la relación
        $acudiente->estudiantes()->detach(request()->estudianteId);
        if ($acudiente->estudiantes->count() == 0) {
            //Buscar el usuario del acudiente para eliminarlo
            $user = User::find($acudiente->user_id);
            //eliminar el acudiente
            $acudiente->delete();
            //eliminar el usuario
            $user->delete();
        }
        return redirect()->back()->with('message', 'Acudiente eliminaado correctamente');        
    }

    // Método para obtener los datos de un acudiente a través de su número de documento
    public function document($documento)
    {
        return $acudiente = Acudiente::where('documento', $documento)->first();
    }

    // Método para agregar un acudiente (en la tabla pivote) que ya existe en la base de datos
    public function agregarAcudienteExistente(Request $request)
    {        
        $acudiente = Acudiente::where('documento', $request->doc)->first();
        if ($acudiente) {    
            //Verificamos que en la tabla pivote no exista el mismo acudiente para un estudiante
            $existe_estudiante = $acudiente->estudiantes->contains($request->estudiante);
            if (!$existe_estudiante) {
                //Guardamos las claves en la tabla pivote
                $acudiente->estudiantes()->attach($request->estudiante);
                return redirect()->back()->with('message', 'Acudiente asignado correctamente'); 
            }
            else {
                return redirect()->back()->with('message', 'Acudiente ya existe en la lista');
            }
        }
    }
}
