<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Proveedor;

class PersonaController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    } 
    public function index(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $personas = DB::table('personas')->get();
        return $personas;

    }
    


}
