<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\RolPermiso;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $permisos = DB::table('rol_permisos')
                        ->select(DB::raw('rol_permisos.estado, permisos.nombrePermiso'))
                        ->join('permisos','rol_permisos.permisoId','=','permisos.id')
                        ->where('rolId','=',Auth::user()->rolId)->get();
        return view('content')->with(compact('permisos'));
    }
}
