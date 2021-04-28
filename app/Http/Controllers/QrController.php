<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use App\Models\Qr;
use Illuminate\Support\Facades\Storage;
use QRcodePNG;

class QrController extends Controller
{
    public function index()
    {
      $QrList = Qr::All();
      $data['QrList'] = $QrList;

      return view('admin/index', $data);
    }

    public function create(){
      $Qr = Qr::all();
      return view('admin/qrForm');
    }

    public function store(Request $request){
      $qr = new Qr();
      $qr->nombre = $request->nombre;
      $qr->enlace = $request->enlace;
      $qr->documento = $request->documento;

      $ruta = "assets/img/qr/" . $qr->nombre;

      QrCode::generate($qr->enlace, public_path('assets/img/qr/' . $qr->nombre . '.svg'));

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
      $qr->nombre = $request->nombre;
      $qr->enlace = $request->enlace;
      $qr->documento = $request->documento;
      $qr->save();
      return redirect()->route('qr.index');
  }

    public function destroy($id){
      $qr = Qr::find($id);
      $qr->delete();
      
      return redirect()->route('qr.index');
    }

}