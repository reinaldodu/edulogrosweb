<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use App\Models\Institucion;
use App\Models\Periodo;
use App\Models\Year;
use App\Models\TipoEvaluacion;
use Carbon\Carbon;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $year_actual = Year::where('id', session('periodoAcademico'))->first();
        $periodo_actual = Periodo::where('year_id', session('periodoAcademico'))
                                    ->whereDate('fecha_inicio', '<=', Carbon::now())
                                    ->whereDate('fecha_fin', '>=', Carbon::now())
                                    ->first();
        
        //Obtener el nombre del tipo de evaluación correspondiente para los logros (siempre es el primero de la lista del año academico)
        $nombre_logros = TipoEvaluacion::where('year_id', session('periodoAcademico'))
                                        ->first()->nombre ?? '';
        //Convertir el nombre del tipo de evaluación logros a singular
        if(substr($nombre_logros, -2) == 'es'){
            $singular_logros = substr($nombre_logros, 0, -2);
        } else if(substr($nombre_logros, -1) == 's'){
            $singular_logros = substr($nombre_logros, 0, -1);
        } else {
            $singular_logros = $nombre_logros;
        }
        
        return array_merge(parent::share($request), [
            'flash' => [
                'message' => session('message')
            ],
            'logo' => Institucion::find(1)->logo,
            'periodo' => $periodo_actual ? $periodo_actual->id : '',
            'nombre_logros' => $nombre_logros, //Nombre que se le dá a los logros
            'singular_logros' => $singular_logros, //Nombre que se le dá a los logros en singular
            'periodo_academico' => $year_actual,
        ]);
    }
}
