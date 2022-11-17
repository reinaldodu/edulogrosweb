<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institucion;
use Illuminate\Http\Request;

use App\Http\Requests\InstitucionRequest;

use Inertia\Inertia;

class InstitucionController extends Controller
{
   
    public function show()
    {
        return Inertia::render('Admin/Institucion/VerInstitucion', [
            'institucion' => Institucion::find(1),
        ]);
    }
    
    public function edit()
    {
        return Inertia::render('Admin/Institucion/EditarInstitucion', [
            'institucion' => Institucion::find(1),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institucion  $institucion
     * @return \Illuminate\Http\Response
     */
    public function update(InstitucionRequest $request)
    {
  
        $institucion = Institucion::find(1);
        //$institucion->fill($request->all());

        $institucion->nombre = $request->nombre;
        $institucion->slogan = $request->slogan;
        $institucion->descripcion = $request->descripcion;
        $institucion->resolucion = $request->resolucion;
        $institucion->direccion = $request->direccion;
        $institucion->telefono = $request->telefono;
        $institucion->email = $request->email;
        $institucion->rector = $request->rector;
        $institucion->web = $request->web;

        //Si se selecciona una imagen se guarda en el disco
        if ($request->hasFile('logo')) {
            $institucion->logo = $request->file('logo')->storeAs('images', 'logo.' . $request->file('logo')->extension(), 'public');
        }

        $institucion->save();
        return redirect()->route('admin.institucion.show')->with('message', 'Datos de la institución actualizados correctamente');
    }

}
