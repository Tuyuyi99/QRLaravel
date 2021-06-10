<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\Models\Userlog;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function authenticated(){
        $idUsuario = auth()->user()->id;
        $usuario = DB::table('users')->where('id', $idUsuario)->first();

        $userlog = new Userlog();
        $userlog->nombre = $usuario->name;
        $userlog->apellidos = $usuario->surname;
        $userlog->email = $usuario->email;
        $userlog->fecha = Carbon::now();
        $userlog->id_usuario = $usuario->id;

        $userlog->save();

        return view('admin/index');
}

    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
