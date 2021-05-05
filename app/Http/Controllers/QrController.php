<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use App\Models\Qr;
use App\Models\Acortador;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class QrController extends Controller
{
    public function index()
    {
      $qrList = Qr::All();
      $acortadorList = Acortador::all();
      $data['qrList'] = $qrList;
      $data ['acortadorListQr'] = $acortadorList;

      return view('admin/index', $data);
    }

    public function create(){
      $qr = Qr::all();
      return view('admin/qrForm');
    }

    public function store(Request $request){
      $qr = new Qr();
      $qr->nombre = $request->nombre;
      $qr->enlace = $request->enlace;

      $ruta = "assets/img/qr/" . $qr->nombre;

      if(!mkdir($ruta, 0777, true)) {
        die('Fallo al crear las carpetas.');
    }

      QrCode::generate($qr->enlace, public_path('assets/img/qr/' . $qr->nombre . '/' . $qr->nombre . '.svg'));

      $qr->save();
      return redirect()->route('qr.index');
    }

    public function show($id){
      $qr = Qr::find($id);
      return view("admin/index");
    }

    public function edit($id){
      $qr = Qr::find($id);
      $data["qr"] = $qr;
      return view('admin/qrForm', $data);
    }

    public function update(Request $request){
      $qr = Qr::find($request->id);
      $nombreAntiguo = $qr->nombre;
      $qr->nombre = $request->nombre;
      $nombreNuevo = $qr->nombre;

      $ruta = "assets/img/qr/";
      $rutaAntigua = "assets/img/qr/" . $nombreAntiguo . '/';
      
      if($nombreAntiguo != $qr->nombre){
        rename($rutaAntigua . $nombreAntiguo . '.svg', $rutaAntigua . $nombreNuevo . '.svg');
        rename($ruta . $nombreAntiguo, $ruta . $nombreNuevo);
    }
      $qr->enlace = $request->enlace;
      $qr->save();
      return redirect()->route('qr.index');
  }

    public function destroy($id){
      $qr = Qr::find($id);

      $ruta = "assets/img/qr/" . $qr->nombre;
      $file = new Filesystem;
      $file->cleanDirectory($ruta);
      
      rmdir($ruta);

      foreach($qr->id_category as $qrAcortador){
        $qrAcortador->delete();
        }

      $qr->delete();
      
      return redirect()->route('qr.index');
    }

}