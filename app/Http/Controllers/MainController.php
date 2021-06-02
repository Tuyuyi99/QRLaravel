<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qr;
use App\Models\Servicio;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $qrList = Qr::All()->sortByDesc('created_at');
      $serviciosListQr = Servicio::All();
      $data['qrList'] = $qrList;
      $data['serviciosListQr'] = $serviciosListQr;
      $mensaje = "Lo sentimos, actualmente no existe ningún QR. Intente volver más tarde.";

      return view('front', $data, compact('mensaje'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
}
