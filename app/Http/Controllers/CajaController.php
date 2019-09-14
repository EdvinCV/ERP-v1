<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Caja;

class CajaController extends Controller
{
    public function store(Request $req){
        try {
            $caja = new Caja;
            $caja->cantidad = $req->cantidad;
            $caja->tipo = $req->tipo;
            $caja->observacion = $req->observacion;
            $caja->idEmpleado = Auth::user()->id;
            $caja->save();
        
            return "Control de caja exitoso";
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
}
