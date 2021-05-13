<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Qr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentosList = Documento::All();
        $data['documentosList'] = $documentosList;
  
        return view('admin/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/documentoForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function store(Request $request){
            $documento = new Documento();
            $documento->nombre = $request->nombre;

            if($request->hasFile("documento")){
                $file = $request->file("documento");
                
                $nombre = $documento->nombre . '.pdf';
    
                $ruta = public_path("assets/PDFs/" . $nombre);
                copy($file, $ruta);

                $documento->documento = $ruta;

            }

            $documento->save();

            return redirect()->route('documento.index');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documento = Documento::find($id);
        return view("admin/documentoForm", ["documentosList" => $documento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documento = Documento::find($id);
        return view('admin/documentoForm', array('documento' => $documento));
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
        $documento = Documento::find($request->id);
        $documento->documento = $request->documento;
        $documento->save();
        return redirect()->route('documento.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documento = Documento::find($id);
        $documento->delete();
        return redirect()->route("documento.index");
    }
}
