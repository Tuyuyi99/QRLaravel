<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;

class UserlogController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
      }
    
    public function store(){

        dd("hola");
        $idUsuario = auth()->user()->id;
        $usuario = DB::table('users')->where('id', $idUsuario);

        $userlog->nombre = $usuario->name;
        $userlog->apellidos = $usuario->surname;
        $userlog->email = $usuario->email;
        $userlog->fecha = Carbon::now();
        $userlog->id_usuario = $usuario->id;

        return view('admin/index');
    }
}
