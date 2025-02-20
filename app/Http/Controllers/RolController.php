<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;


class RolController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    } 
    public function index(){
        return Rol::orderBy('created_at', 'desc')
                    ->where('estado','=',1)
                    ->get();
    }
    public function edit(Request $request){
        $id=$request->id;
        $nombre=$request->nombre;
        try{

            $rol=Rol::findOrFail($id);
            $rol->nombreRol=$nombre;
            $rol->save();
            return 'Se ha modificado el rol correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function store(Request $request){
        $nombre=$request->nombre;
        try{
            $rol=new Rol;
            $rol->nombreRol=$nombre;
            $rol->save();
            return 'Se ha agregado el rol correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function drop(Rol $rol){
        try{
            $rol->estado = false;
            $rol->save();
            return 'Rol eliminado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
       
    }
}
