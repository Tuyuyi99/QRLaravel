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
      $qrList = Qr::All();
      $serviciosListQr = Servicio::All();
      $data['qrList'] = $qrList;
      $data['serviciosListQr'] = $serviciosListQr;

      return view('front', $data);
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
