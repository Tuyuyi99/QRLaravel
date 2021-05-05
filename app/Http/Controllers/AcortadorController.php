<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acortador;
use App\Models\Qr;
use Illuminate\Support\Str;

class AcortadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $acortadorList = Acortador::All();
      $data['acortadorList'] = $acortadorList;

      return view('admin/index', $data);
    }

    public function create(){
        $qr = Qr::all();
        return view('admin/acortadorForm', ['qrList' => $qr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qr = Qr::find($request->id_qr);
        $request->validate([
            'link' => 'required|url'
         ]);
 
         $input['link'] = $request->link;
         $input['codigo'] = Str::random(6);
         $input['id_qr'] = $request->id_qr;
 
         Acortador::create($input);
 
         return redirect('admin');
    }

    public function edit($id){
      $acortador = Acortador::find($id);
      $qr = Qr::all();
      $data["qrList"] = $qr;
      $data["acortador"] = $acortador;
      
      return view('admin/acortadorEdit', $data);
    }

    public function update(Request $request){
      $acortador = Acortador::find($request->id);    
      $acortador->codigo = $request->codigo;
      $acortador->link = $request->link;
      $acortador->id_qr = $request->id_qr;
      $acortador->save();
      return redirect()->route('qr.index');
  }

  public function destroy($id){
    $acortador = Acortador::find($id);

    $acortador->delete();
    
    return redirect()->route('qr.index');
  }

    public function acortarLink($codigo)
    {
        $find = Acortador::where('codigo', $codigo)->first();

        return redirect($find->link);
    }
}
