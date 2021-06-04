<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
      }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarioId = auth()->user()->id;

        $rol = auth()->user()->rol->rol;
  
        if($rol == 'usuario'){
          $serviciosList = DB::table('servicios')->Where('id_usuario', '=', $usuarioId)->get()->sortByDesc('created_at');;
          $data['serviciosList'] = $serviciosList;
  
          $mensaje = "Actualmente no existe ningún servicio creado.";
          return view('admin/index', $data, compact('mensaje'));
      } else{

        $serviciosList = Servicio::All()->sortByDesc('created_at');
        $userListServicio = User::all();
        $data['serviciosList'] = $serviciosList;
        $data['userListServicio'] = $userListServicio;
        $mensaje = "Actualmente no existe ningún servicio creado.";
  
        return view('admin/index', $data, compact('mensaje'));
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $usuarios = User::all();
      $data['usuarios'] = $usuarios;
        return view('admin/servicioForm', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuarioId = auth()->user()->id;
        $serviciosList = Servicio::All();

        $usuario = DB::table('users')->where('id', $usuarioId)->first();

        $servicio = new Servicio();
        $servicio->servicio = $request->servicio;
        $servicio->id_usuario = $usuarioId;

        foreach($serviciosList as $servicioExistente){
            if (($servicio->servicio == $servicioExistente->servicio) && ($usuario->id == $servicio->id_usuario)){
                return redirect()->route('servicio.index')->with('message', 'Ese servicio ya existe. Prueba a crear otro que no se llame ' . $servicio->servicio . '.');
            }
        }

        $rutaQr = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicio->servicio . '/qr';
        $rutaDocumentos = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicio->servicio . '/documentos';
      if(!mkdir($rutaQr, 0777, true)) {
        die('Fallo al crear las carpetas.');
      }
      if(!mkdir($rutaDocumentos, 0777, true)) {
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
        $usuarios = User::all();

        $data["servicio"] = $servicio;
        $data['usuarios'] = $usuarios;
        return view('admin/servicioForm', $data);
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
        $usuarioId = auth()->user()->id;
        $servicio = Servicio::find($request->id);
        $usuario = DB::table('users')->where('id', $usuarioId)->first();

        $nombreAntiguo = $servicio->servicio;
        $servicio->servicio = $request->servicio;
        $nombreNuevo = $servicio->servicio;
        $servicio->id_usuario = $usuarioId;

        $rutaEnlace = "assets/usuarios/" . $usuario->name . ' ' . $usuario->surname . "/servicios/";
      
      if($nombreAntiguo != $servicio->servicio){
        rename($rutaEnlace . $nombreAntiguo, $rutaEnlace . $nombreNuevo);
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
        $usuarioId = auth()->user()->id;
        $usuario = DB::table('users')->where('id', $usuarioId)->first();

        $ruta = "assets/usuarios/" . $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicio->servicio . '/qr';
        $rutaDocumentos = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicio->servicio . '/documentos/';
        $carpetaServicios = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicio->servicio;
        $file = new Filesystem;
        $file->cleanDirectory($ruta);

        $documentos = $file->allFiles($rutaDocumentos);

        $file->delete($documentos);
        
        rmdir($ruta);
        rmdir($rutaDocumentos);
        rmdir($carpetaServicios);
  
        $servicio->delete();
        return redirect()->route('servicio.index');
    }
}