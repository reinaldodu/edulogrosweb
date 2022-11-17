<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class ContratoController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrato $contrato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrato $contrato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrato $contrato)
    {
        //
    }

    public function exportarContratoPdf(Estudiante $estudiante, $plantilla)
    {
        //Configuración render PDF para phpWord usando DomPDF
        $domPdfPath = base_path( 'vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        //Verificar si existe la plantilla de word
        $pathTemplate=storage_path("app/public/plantillas/{$plantilla}.docx");
        if (!file_exists($pathTemplate)) {
            return to_route('admin.contratos.index')->with('message', 'No se encontró la plantilla');
        }
        //Leer la plantilla
        $template= new \PhpOffice\PhpWord\TemplateProcessor($pathTemplate);
        
        //Variables del estudiante
        $template->setValue('estudiante_nombres', $estudiante->nombres);
        $template->setValue('estudiante_apellidos', $estudiante->apellidos);
        $template->setValue('estudiante_documento', $estudiante->documento);
        //Seleccionar el grado del estudiante del año actual
        $grado=$estudiante->grados()->where('year_id', session('periodoAcademico'))->first();
        $template->setValue('estudiante_grado', $grado->nombre);

        //Variables del acudiente->madre
        $madre=$estudiante->acudientes()->with('user')->where('parentesco_id', 1)->first();
        if ($madre) {
            $template->setValue('madre_nombre', $madre->nombres.' '.$madre->apellidos);
            $template->setValue('madre_documento', $madre->documento);
            $template->setValue('madre_email', $madre->user->email);
        } else {
            $template->setValue('madre_nombre', '');
            $template->setValue('madre_documento', '');
            $template->setValue('madre_email', '');
        }

        //Rutas de los archivos temporales docx y pdf
        $saveDocPath = storage_path("app/public/plantillas/{$plantilla}_tmp.docx");
        $savePdfPath = storage_path("app/public/plantillas/{$plantilla}.pdf");
        try{
            $template->saveAs($saveDocPath);
            //convertir en pdf
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($saveDocPath);
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
            $xmlWriter->save($savePdfPath);
        }catch (\PhpOffice\PhpWord\Exception\Exception $e){
            return $e->getMessage();
        }
        //eliminar el archivo temporal docx
        if ( file_exists($saveDocPath) ) {
            unlink($saveDocPath);
        }
        return response()->download($savePdfPath)->deleteFileAfterSend(true);  //Se descarga la plantilla con datos en formato PDF
    }
}
