<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviciosList = Servicio::All();
        $data['serviciosList'] = $serviciosList;
  
        return view('admin/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/servicioForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $servicio = new Servicio();
        $servicio->servicio = $request->servicio;

        $rutaEnlace = "assets/img/qr/" . $servicio->servicio;
        $rutaPDF = "assets/PDFs/" . $servicio->servicio;

      if(!mkdir($rutaEnlace, 0777, true)) {
        die('Fallo al crear las carpetas.');
      }

      if(!mkdir($rutaPDF, 0777, true)) {
        die('Fallo al crear las carpetas.');
      }

        $servicio->save();
        return redirect()->route('servicio.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicio = Servicio::find($id);
        return view("admin/servicioForm", ["serviciosList" => $servicio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicio = Servicio::find($id);
        return view('admin/servicioForm', array('servicio' => $servicio));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::find($request->id);

        $nombreAntiguo = $servicio->servicio;
        $servicio->servicio = $request->servicio;
        $nombreNuevo = $servicio->servicio;

        $rutaEnlace = "assets/img/qr/";
        $rutaDocumento = "assets/PDFs/";
      
      if($nombreAntiguo != $servicio->servicio){
        rename($rutaEnlace . $nombreAntiguo, $rutaEnlace . $nombreNuevo);
    }

    if($nombreAntiguo != $servicio->servicio){
        rename($rutaDocumento . $nombreAntiguo, $rutaDocumento . $nombreNuevo);
    }

        $servicio->save();
        return redirect()->route('servicio.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Servicio::find($id);
        DB::table('qrs')->where('id_servicio', '=', $servicio->id)->delete();

        $rutaEnlace = "assets/img/qr/" . $servicio->servicio;
        $rutaDocumento = "assets/PDFs/" . $servicio->servicio;
        $file = new Filesystem;
        $file->cleanDirectory($rutaEnlace);
        $file->cleanDirectory($rutaDocumento);
        
        rmdir($rutaEnlace);
        rmdir($rutaDocumento);
  
        $servicio->delete();
        return redirect()->route('servicio.index');
    }
}
