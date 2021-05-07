<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use App\Models\Qr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class QrController extends Controller
{
    public function index()
    {
      $qrList = Qr::All();
      $data['qrList'] = $qrList;

      return view('admin/index', $data);
    }

    public function create(){
      $qr = Qr::all();
      //dd($qr);
      return view('admin/qrForm');
    }

    public function store(Request $request){
      $qr = new Qr();

      $request->validate([
        'enlace' => 'required|url'
     ]);

      $qr->nombre = $request->nombre;
      $qr->enlace = $request->enlace;
      $qr->codigo = Str::random(6);

      $ruta = "assets/img/qr/" . $qr->nombre;

      if(!mkdir($ruta, 0777, true)) {
        die('Fallo al crear las carpetas.');
    }

      QrCode::generate(route('acortar.link', $qr->codigo), public_path('assets/img/qr/' . $qr->nombre . '/' . $qr->nombre . '.svg'));

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

      $qr->delete();
      
      return redirect()->route('qr.index');
    }

    public function acortarLink($codigo)
    {

        $find = Qr::where('codigo', $codigo)->first();

        return redirect($find->enlace);
    }

}