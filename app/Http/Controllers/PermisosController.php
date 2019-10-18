<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RolPermiso;
use App\Rol;

class PermisosController extends Controller
{  
    //
    public function __construct(){
        $this->middleware('auth');
    } 
    public function index(){
        $permisos = DB::table('rol_permisos')
                        ->select(DB::raw('rol_permisos.id,rol_permisos.estado, permisos.nombrePermiso, rols.nombreRol'))
                        ->join('permisos','rol_permisos.permisoId','=','permisos.id')
                        ->join('rols','rol_permisos.rolId','=','rols.id')
                        ->get();
        return $permisos;
    }

    public function edit(Request $request){
        $id=$request->id;
        $estado=$request->estado;
        try{
            $permiso=RolPermiso::findOrFail($id);
            $permiso->estado=$estado;
            $permiso->save();
            return 'Se ha modificado el permiso correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function store(Request $request){
        try{
            $rolP=new RolPermiso;
            $rolP->rolId = $request->nombreRol;
            $rolP->permisoId = $request->nombrePermiso;
            $rolP->save();
            return 'Permiso agregado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function listarPermisos(){
        $listaP = DB::table('permisos')->get();
        return $listaP;        
    }

    public function drop(RolPermiso $rolP){
        try{
            $rolP->delete();
            return 'Permiso eliminado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    
}
