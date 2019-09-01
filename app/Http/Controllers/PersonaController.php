<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Proveedor;

class PersonaController extends Controller
{
    //
    public function index(){
        $personas = DB::table('personas')->get();
        return $personas;

    }
    


}
