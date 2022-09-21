<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

//****Grupo de rutas para el administrador****
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //Rutas institución
    Route::get('institucion', [App\Http\Controllers\Admin\InstitucionController::class, 'show'])->name('institucion.show');
    Route::get('institucion/edit', [App\Http\Controllers\Admin\InstitucionController::class, 'edit'])->name('institucion.edit');
    Route::put('institucion', [App\Http\Controllers\Admin\InstitucionController::class, 'update'])->name('institucion.update');

    //Rutas estudiantes (Se crean 7 rutas con resource)
    Route::resource('estudiantes', App\Http\Controllers\Admin\EstudianteController::class);
    
    //Rutas acudientes
    Route::resource('acudientes', App\Http\Controllers\Admin\AcudienteController::class)->only(['store', 'update','destroy']);

    //Consultar acudiente por documento
    Route::get('acudientes/{doc}', [App\Http\Controllers\Admin\AcudienteController::class, 'document'])->name('acudientes.doc');

    //Ruta para agregar el acudiente_id y estudiante_id a la tabla pivote acudiente_estudiante
    Route::post('acudientes/vincular', [App\Http\Controllers\Admin\AcudienteController::class, 'agregarAcudienteExistente'])->name('acudientes.vincular');

    //Rutas profesores
    Route::resource('profesores', App\Http\Controllers\Admin\ProfesorController::class)
        ->parameters(['profesores' => 'profesor']);

    //Rutas areas
    Route::resource('areas', App\Http\Controllers\Admin\AreaController::class);

    //Rutas asignaturas
    Route::resource('asignaturas', App\Http\Controllers\Admin\AsignaturaController::class);

    //Rutas grupos
    Route::resource('grupos', App\Http\Controllers\Admin\GrupoController::class);

    //Ruta para agregar un estudiante a un grupo (tabla pivote estudiante_grupo)
    Route::post('grupos/agrega_estudiante', [App\Http\Controllers\Admin\GrupoController::class, 'agregarEstudianteGrupo'])->name('grupos.addstudent');

    //Ruta para eliminar un estudiante de un grupo (tabla pivote estudiante_grupo)
    Route::delete('grupos/{grupo}/{estudiante}', [App\Http\Controllers\Admin\GrupoController::class, 'eliminarEstudianteGrupo'])->name('grupos.deletestudent');

    //Rutas asignación académica (carga académica)
    Route::resource('asignaciones', App\Http\Controllers\Admin\AsignacionController::class)
        ->parameters(['asignaciones' => 'asignacion']);

    //Rutas periodos
    Route::resource('periodos', App\Http\Controllers\Admin\PeriodoController::class);

    //Ruta inicial para consultar logros
    Route::get('logros', [App\Http\Controllers\Admin\LogroController::class, 'show'])->name('logros.index');
    
    //Ruta para consultar logros por periodo, grupo y asignatura
    Route::get('logros/{periodo}/{grupo}/{asignatura}', [App\Http\Controllers\Admin\LogroController::class, 'show'])->name('logros.show');

    //Ruta para guardar logros por periodo, grupo y asignatura
    Route::post('logros/{periodo}/{grupo}/{asignatura}', [App\Http\Controllers\Admin\LogroController::class, 'store'])->name('logros.store');

    //Ruta para actualizar un logro
    Route::put('logros/{logro}', [App\Http\Controllers\Admin\LogroController::class, 'update'])->name('logros.update');

    //Ruta para eliminar un logro
    Route::delete('logros/{logro}', [App\Http\Controllers\Admin\LogroController::class, 'destroy'])->name('logros.destroy');

   
    //Ruta inicial para consultar observaciones
    Route::get('observaciones', [App\Http\Controllers\Admin\ObservacionController::class, 'show'])->name('observaciones.index');
    
    //Ruta para consultar observaciones por grado y asignatura
    Route::get('observaciones/{grado}/{asignatura}', [App\Http\Controllers\Admin\ObservacionController::class, 'show'])->name('observaciones.show');

    //Ruta para guardar observaciones por grado y asignatura
    Route::post('observaciones/{grado}/{asignatura}', [App\Http\Controllers\Admin\ObservacionController::class, 'store'])->name('observaciones.store');

    //Ruta para actualizar una observación
    Route::put('observaciones/{observacion}', [App\Http\Controllers\Admin\ObservacionController::class, 'update'])->name('observaciones.update');

    //Ruta para eliminar una observación
    Route::delete('observaciones/{observacion}', [App\Http\Controllers\Admin\ObservacionController::class, 'destroy'])->name('observaciones.destroy');

    
    //Rutas tipos de observaciones (ej: Fortalezas, recomendaciones, sugerencias)
    Route::resource('tipo-observaciones', App\Http\Controllers\Admin\TipoObservacionController::class)
        ->parameters(['tipo-observaciones' => 'tipo_observacion']);

    //Rutas tipo de evaluaciones (ej: logros, evaluación final, convivencia)
    Route::resource('tipo-evaluaciones', App\Http\Controllers\Admin\TipoEvaluacionController::class)
        ->parameters(['tipo-evaluaciones' => 'tipo_evaluacion']);

    //Rutas sistema de evaluación
    Route::resource('sistema-evaluacion', App\Http\Controllers\Admin\SistemaEvaluacionController::class);

    //Ruta para consultar el panel de administración de las evaluaciones
    Route::get('panel-evaluaciones', [App\Http\Controllers\Admin\PanelEvaluacionController::class, 'index'])->name('panel-evaluaciones.index');
    Route::get('panel-evaluaciones/{periodo}/{grupo}/{asignatura}', [App\Http\Controllers\Admin\PanelEvaluacionController::class, 'show'])->name('panel-evaluaciones.show');
    
    //Ruta para las evaluaciones por logros
    Route::get('evaluar-logros/{logro}/{actividad?}', [App\Http\Controllers\Admin\NotaLogroController::class, 'show'])->name('evaluar-logros.show');
    Route::post('evaluar-logros/{logro}/{actividad?}', [App\Http\Controllers\Admin\NotaLogroController::class, 'store'])->name('evaluar-logros.store');
    
    //Ruta para las evaluaciones generales
    Route::get('evaluar-generales/{tipo}/{asignatura}/{periodo}/{grupo}/{actividad?}', [App\Http\Controllers\Admin\NotaGeneralController::class, 'show'])->name('evaluar-generales.show');
    Route::post('evaluar-generales/{tipo}/{asignatura}/{periodo}/{grupo}/{actividad?}', [App\Http\Controllers\Admin\NotaGeneralController::class, 'store'])->name('evaluar-generales.store');

    //Rutas para las actividades de logros
    Route::post('actividad-logros', [App\Http\Controllers\Admin\ActividadLogroController::class, 'store'])->name('actividad-logros.store');
    Route::put('actividad-logros/{actividad}', [App\Http\Controllers\Admin\ActividadLogroController::class, 'update'])->name('actividad-logros.update');
    Route::delete('actividad-logros/{actividad}', [App\Http\Controllers\Admin\ActividadLogroController::class, 'destroy'])->name('actividad-logros.destroy');

    //Rutas para las actividades generales
    Route::post('actividad-general', [App\Http\Controllers\Admin\ActividadGeneralController::class, 'store'])->name('actividad-general.store');
    Route::put('actividad-general/{actividad}', [App\Http\Controllers\Admin\ActividadGeneralController::class, 'update'])->name('actividad-general.update');
    Route::delete('actividad-general/{actividad}', [App\Http\Controllers\Admin\ActividadGeneralController::class, 'destroy'])->name('actividad-general.destroy');
    
    //Ruta inicial para consultar notas
    // Route::get('notas', [App\Http\Controllers\Admin\NotaController::class, 'index'])->name('notas.index');
    // Route::get('notas/{periodo}/{grupo}/{asignatura}', [App\Http\Controllers\Admin\NotaController::class, 'show'])->name('notas.show');
    // Route::post('notas/{periodo}/{grupo}/{asignatura}', [App\Http\Controllers\Admin\NotaController::class, 'store'])->name('notas.store');

    //Rutas escala de valoraciones (Db, DB, DA, DS) por grado
    Route::resource('escala-valoracion', App\Http\Controllers\Admin\EscalaValoracionController::class);

});
