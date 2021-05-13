<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

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

        $ruta = "assets/img/qr/" . $servicio->servicio;

      if(!mkdir($ruta, 0777, true)) {
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
        $servicio = servicio::find($request->id);

        $nombreAntiguo = $servicio->servicio;
        $servicio->servicio = $request->servicio;
        $nombreNuevo = $servicio->servicio;

        $ruta = "assets/img/qr/";
        $rutaAntigua = "assets/img/qr/" . $nombreAntiguo . '/';
      
      if($nombreAntiguo != $servicio->servicio){
        rename($ruta . $nombreAntiguo, $ruta . $nombreNuevo);
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

        $ruta = "assets/img/qr/" . $servicio->servicio;
        $file = new Filesystem;
        $file->cleanDirectory($ruta);
        
        rmdir($ruta);
  
        $servicio->delete();
        return redirect()->route('servicio.index');
    }
}
