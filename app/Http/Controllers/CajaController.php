<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Caja;

class CajaController extends Controller
{
    public function index(Request $request)
    {
        $caja = DB::table('cajas')
            ->select(DB::raw('cajas.id, cajas.cantidad, cajas.created_at,users.name,cajas.tipo, cajas.observacion'))
            ->join('users','cajas.idEmpleado','=','users.id')->get();
        return $caja;
    }

    public function estado(Request $request)
    {
        $caja = DB::table('cajas')
            ->select(DB::raw('cajas.cantidad, cajas.tipo'))
            ->orderby('cajas.id','desc')
            ->limit(2)
            ->get();
        return $caja;
    }
    
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

    public function cierre(Request $req)
    {
        $caja =  DB::table('cajas')
        ->select(DB::raw('cajas.cantidad, cajas.tipo'))
        ->orderby('cajas.id','desc')
        ->limit(1)
        ->get();
        return view('layout',compact($caja));
    }
}
