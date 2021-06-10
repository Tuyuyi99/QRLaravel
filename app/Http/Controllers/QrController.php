<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use App\Models\Qr;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class QrController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }

    public function index(){
      $usuarioId = auth()->user()->id;
      $rol = auth()->user()->rol->rol;

      if($rol == 'usuario'){
        $qrList = DB::table('qrs')->Where('id_usuario', '=', $usuarioId)->get()->sortByDesc('created_at');

        $serviciosListQr = Servicio::All();
        $data['qrList'] = $qrList;
        $data['serviciosListQr'] = $serviciosListQr;

        $mensaje = "Actualmente no existe ningún servicio creado.";
        return view('admin/index', $data, compact('mensaje'));
    } else{

        $qrList = Qr::all()->sortByDesc('created_at');
        $serviciosListQr = Servicio::All();
        $userListQr = User::all();
        $data['userListQr'] = $userListQr;
        $data['qrList'] = $qrList;
        $data['serviciosListQr'] = $serviciosListQr;

        $mensaje = "Actualmente no existe ningún servicio creado.";
        return view('admin/index', $data, compact('mensaje'));
      }
    }

    public function createDocumento(){
      $servicios = Servicio::all();
      $usuarios = User::all();
      $data['serviciosList'] = $servicios;
      $data['usuarios'] = $usuarios;
      return view('admin/qrFormDocumento', $data);
    }

    public function createEnlace(){
      $servicios = Servicio::all();
      $usuarios = User::all();
      $data['serviciosList'] = $servicios;
      $data['usuarios'] = $usuarios;
      return view('admin/qrFormEnlace', $data);
    }

    public function store(Request $request){
      $qr = new Qr();
      $servicios = Servicio::find($request->id_servicio);
      $usuarioId = auth()->user()->id;
      $usuario = DB::table('users')->where('id', $usuarioId)->first();

      $qr->nombre = $request->nombre;
      $qr->codigo = Str::random(10);    
      $qr->enlace = $request->enlace;
      $qr->id_servicio = $request->id_servicio;
      $qr->id_usuario = $usuarioId;
      $ruta = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicios->servicio . "/qr/" . $qr->nombre;

      if(!mkdir($ruta, 0777, true)) {
        die('Fallo al crear las carpetas.');
    }

      QrCode::size(500)
      ->generate($qr->enlace, public_path('assets/usuarios/' . $usuario->name . ' ' . $usuario->surname .'/servicios/' . $servicios->servicio . '/qr/' . $qr->nombre . '/' . $qr->nombre . '.svg'));

      $qr->save();

      return redirect()->route('qr.index');
    }

    public function subirDocumento(Request $request){
      $servicios = Servicio::find($request->id_servicio);
      $usuarioId = auth()->user()->id;
      $usuario = DB::table('users')->where('id', $usuarioId)->first();
      
      foreach ($request->documento as $file){
          $qr = new Qr();
          $qr->nombre = $request->nombre;
          $qr->codigo = Str::random(10);
          $qr->id_servicio = $request->id_servicio;
          $qr->id_usuario = $usuarioId;

          $now = date('Y-m-d H-i-s');
          $nombre = Carbon::createFromFormat('Y-m-d H-i-s', $now, 'Europe/Paris')->format('d-m-Y H-i-s') . ' - ';
          $nombre = $nombre . $file->getClientOriginalName();

          $file->move(public_path('assets/usuarios/'. $usuario->name . ' ' . $usuario->surname . '/servicios/' . $servicios->servicio . '/documentos/'), $nombre);

          $ruta = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicios->servicio . "/qr/" . $qr->nombre;

          if(!mkdir($ruta, 0777, true)) {
            die('Fallo al crear las carpetas.');
        }

          QrCode::size(500)
          ->generate(route('acortar.linkDocumento', $qr->codigo), public_path("assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicios->servicio . '/qr/' . $qr->nombre . '/' . $qr->nombre . '.svg'));
      

          $qr->documento = $nombre;
                
          $qr->save();
      }

      return redirect()->route('qr.index');
  }

    public function show($id){
      $qr = Qr::find($id);
      return view("admin/qr");
    }

    public function editEnlace($id){
      $qr = Qr::find($id);
      $servicios = Servicio::all();
      $usuarios = User::all();
      $data["qr"] = $qr;
      $data["serviciosList"] = $servicios;
      $data['usuariosList'] = $usuarios;
      return view('admin/qrFormEnlace', $data);
    }
    public function editDocumento($id){
      $qr = Qr::find($id);
      $servicios = Servicio::all();
      $usuarios = User::all();
      $data["qr"] = $qr;
      $data["serviciosList"] = $servicios;
      $data['usuariosList'] = $usuarios;
      return view('admin/qrFormDocumento', $data);
    }

  public function updateEnlace(Request $request){
    $qr = Qr::find($request->id);
    $servicioAntiguo = DB::table('servicios')->where('id', $qr->id_servicio)->first();
    $servicioNuevo = Servicio::find($request->id_servicio);
    $usuarioId = auth()->user()->id;
    $usuario = DB::table('users')->where('id', $usuarioId)->first();
    

    $nombreAntiguo = $qr->nombre;
    $qr->nombre = $request->nombre;
    $nombreNuevo = $qr->nombre;
    $qr->id_servicio = $request->id_servicio;
    $qr->id_usuario = $usuarioId;

    $rutaNueva = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioNuevo->servicio . '/qr/' . $nombreNuevo;
    $rutaAntigua = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioAntiguo->servicio . '/qr/' . $nombreAntiguo;

    $file = new Filesystem;
    $file->cleanDirectory($rutaAntigua);

    rmdir($rutaAntigua);
        
    if(!mkdir($rutaNueva, 0777, true)) {
      die('Fallo al crear las carpetas.');
    }
      

    QrCode::size(500)
    ->generate($qr->enlace, public_path("assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioNuevo->servicio . '/qr/' . $qr->nombre . '/' . $qr->nombre . '.svg'));

    $qr->enlace = $request->enlace;
    $qr->save();
    return redirect()->route('qr.index');
}

public function updateDocumento(Request $request){
  $qr = Qr::find($request->id);
  $servicioAntiguo = DB::table('servicios')->where('id', $qr->id_servicio)->first();
  $servicioNuevo = Servicio::find($request->id_servicio);
  $usuarioId = auth()->user()->id;
  $usuario = DB::table('users')->where('id', $usuarioId)->first();
  
  $documentoAntiguo = $qr->documento;

  $nombreAntiguo = $qr->nombre;
  $qr->nombre = $request->nombre;
  $nombreNuevo = $qr->nombre;
  $qr->id_servicio = $request->id_servicio;
  $qr->id_usuario = $usuarioId;

  if ($request->documento != NULL){

    foreach ($request->documento as $file){
      $qr->nombre = $request->nombre;
      $qr->id_servicio = $request->id_servicio;
      $qr->id_usuario = $usuarioId;

      $now = date('Y-m-d H-i-s');
      $nombre = Carbon::createFromFormat('Y-m-d H-i-s', $now, 'Europe/Paris')->format('d-m-Y H-i-s') . ' - ';
      $nombre = $nombre . $file->getClientOriginalName();
      

      $file->move(public_path('assets/usuarios/'. $usuario->name . ' ' . $usuario->surname . '/servicios/' . $servicioNuevo->servicio . '/documentos/'), $nombre);

      $rutaNueva = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioNuevo->servicio . '/qr/' . $nombreNuevo;
      $rutaAntigua = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioAntiguo->servicio . '/qr/' . $nombreAntiguo;

      $file = new Filesystem;
      $file->cleanDirectory($rutaAntigua);


      rmdir($rutaAntigua);
        
      if(!mkdir($rutaNueva, 0777, true)) {
        die('Fallo al crear las carpetas.');
      }    
  
      QrCode::size(500)
      ->generate(route('acortar.linkDocumento', $qr->codigo), public_path("assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioNuevo->servicio . '/qr/' . $qr->nombre . '/' . $qr->nombre . '.svg'));
  

      $qr->documento = $nombre;

      $documentoNuevo = $qr->documento;

      $rutaNueva = "assets/usuarios/" . $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioNuevo->servicio . '/documentos/' . $documentoAntiguo;
      $rutaAntigua = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicioAntiguo->servicio . '/documentos/' . $documentoAntiguo;  
    
      $file = new Filesystem;
      $file->delete($rutaAntigua);   

  }
  $qr->documento = $nombre;
}

$qr->nombre = $request->nombre;

  $qr->save();
  return redirect()->route('qr.index');
}

    public function destroy($id){
      $qr = Qr::find($id);
      $servicios = DB::table('servicios')->where('id', $qr->id_servicio)->first();
      $usuarioId = auth()->user()->id;
      $usuario = DB::table('users')->where('id', $usuarioId)->first();

      $ruta = "assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicios->servicio . '/qr/' . $qr->nombre;
      $documentoAEliminar = public_path("assets/usuarios/". $usuario->name . ' ' . $usuario->surname . "/servicios/" . $servicios->servicio . '/documentos/' . $qr->documento);
      $file = new Filesystem;

      $file->delete($documentoAEliminar);
      
      if ($qr->enlace != NULL) {
        $file->cleanDirectory($ruta);
        rmdir($ruta);
      }

      $qr->delete();
      
      return redirect()->route('qr.index');
    }

    public function buscador(Request $request){
       $servicios = Servicio::with('qr')->get();
       $qrs = Qr::where("nombre",'like',"%" . $request->texto."%")->orderByDesc('created_at')->get();


      return view("admin/qrBuscador", compact('servicios', 'qrs'));        
    }

    public function filtrarServicio(request $request){

      $servicios = Servicio::with('qr')->get();
      $qrs = Qr::where("id_servicio", "=", $request->idServicio)->orderByDesc('created_at')->get();

      return view('admin/filtrarIndex', compact('servicios', 'qrs'));
    }

    public function acortarLinkEnlace($codigo){

        $qr = Qr::where('codigo', $codigo)->first();

        return redirect($qr->enlace);
    }

    public function acortarLinkDocumento($codigo){
        $qr = Qr::where('codigo', $codigo)->first();
        $usuarioId = auth()->user()->id;
        $usuario = DB::table('users')->where('id', $usuarioId)->first();

        $nombreServicio = DB::table('servicios')->where('id', $qr->id_servicio)->value('servicio');

        $ruta = 'assets/usuarios/' . $usuario->name . ' ' . $usuario->surname . '/servicios/' . $nombreServicio . '/documentos/' . $qr->documento;

        return redirect($ruta);
    }

}