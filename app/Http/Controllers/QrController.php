<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use App\Models\Qr;
use App\Models\Servicio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QrController extends Controller
{
    public function index()
    {
      $qrList = Qr::All();
      $serviciosListQr = Servicio::All();
      $data['qrList'] = $qrList;
      $data['serviciosListQr'] = $serviciosListQr;
      
      return view('admin/index', $data);
    }

    public function createDocumento(){
      $servicios = Servicio::all();
      return view('admin/qrFormDocumento', ['serviciosList' => $servicios]);
    }

    public function createEnlace(){
      $servicios = Servicio::all();
      return view('admin/qrFormEnlace', ['serviciosList' => $servicios]);
    }

    public function store(Request $request){
      $qr = new Qr();
      $servicios = Servicio::find($request->id_servicio);

      $qr->nombre = $request->nombre;
      $qr->codigo = Str::random(6);    
      $qr->enlace = $request->enlace;
      $qr->id_servicio = $request->id_servicio;


      $ruta = "assets/img/qr/" . $servicios->servicio . '/' . $qr->nombre;

      if(!mkdir($ruta, 0777, true)) {
        die('Fallo al crear las carpetas.');
    }

      QrCode::size(500)
      ->generate(route('acortar.linkEnlace', $qr->codigo), public_path('assets/img/qr/' . $servicios->servicio . '/' . $qr->nombre . '/' . $qr->nombre . '.svg'));

      $qr->save();

      return redirect()->route('qr.index');
    }

    public function subirDocumento(Request $request){
      $servicios = Servicio::find($request->id_servicio);
      
      foreach ($request->documento as $file) {
          $qr = new Qr();
          $qr->nombre = $request->nombre;
          $qr->codigo = Str::random(6);
          $qr->id_servicio = $request->id_servicio;

          $now = date('Y-m-d H-i-s');

          $nombre = Carbon::createFromFormat('Y-m-d H-i-s', $now, 'Europe/Paris')->addHours(2)->format('Y-m-d H-i-s') . ' - ';

          $nombre = $nombre . $file->getClientOriginalName();
          

          $file->move(public_path('assets/documentos/' . $servicios->servicio . '/'), $nombre);

          $qr->documento = $nombre;
                
          $qr->save();
      }

      return redirect()->route('qr.index');
  }

    public function show($id){
      $qr = Qr::find($id);
      return view("admin/qr");
    }

    public function edit($id){
      $qr = Qr::find($id);
      $servicios = Servicio::all();
      $data["qr"] = $qr;
      $data["serviciosList"] = $servicios;
      return view('admin/qrFormEnlace', $data);
    }

  public function update(Request $request){
    $qr = Qr::find($request->id);
    $servicioAntiguo = DB::table('servicios')->where('id', $qr->id_servicio)->first();
    $servicioNuevo = Servicio::find($request->id_servicio);

    $nombreAntiguo = $qr->nombre;
    $qr->nombre = $request->nombre;
    $nombreNuevo = $qr->nombre;
    $qr->id_servicio = $request->id_servicio;

    $rutaNueva = "assets/img/qr/" . $servicioNuevo->servicio . '/' . $nombreNuevo;
    $rutaAntigua = "assets/img/qr/" . $servicioAntiguo->servicio . '/' . $nombreAntiguo;

    $file = new Filesystem;
    $file->cleanDirectory($rutaAntigua);

    rmdir($rutaAntigua);
    
    if(!mkdir($rutaNueva, 0777, true)) {
      die('Fallo al crear las carpetas.');
  }

  QrCode::size(500)
    ->generate(route('acortar.linkEnlace', $qr->codigo), public_path('assets/img/qr/' . $servicioNuevo->servicio . '/' . $qr->nombre . '/' . $qr->nombre . '.svg'));

    $qr->enlace = $request->enlace;
    $qr->save();
    return redirect()->route('qr.index');
}

    public function destroy($id){
      $qr = Qr::find($id);
      $servicios = DB::table('servicios')->where('id', $qr->id_servicio)->first();

      $ruta = "assets/img/qr/" . $servicios->servicio . '/' . $qr->nombre;
      $documentoAEliminar = public_path("assets/documentos/" . $servicios->servicio . '/' . $qr->documento);
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
       $nombres = Qr::where("nombre",'like',$request->texto."%")->take(10)->get();

      return view("admin/qrBuscador", compact('servicios', 'nombres'));        
    }

    public function filtrarServicio($id) {
      $servicio = Servicio::find($id);
      $qrList = Qr::where('id_servicio', '=', $servicio->id)->get();
      $data['qrList'] = $qrList;

      return view('admin/index', $data);
    }

    public function acortarLinkEnlace($codigo)
    {

        $find = Qr::where('codigo', $codigo)->first();

        return redirect($find->enlace);
    }

    public function acortarLinkDocumento($codigo)
    {
        $find = Qr::where('codigo', $codigo)->first();

        return redirect($find->documento);
    }

}