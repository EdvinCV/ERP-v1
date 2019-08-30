<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RolPermiso;

class PermisosController extends Controller
{
    //
    public function index(){
        $permisos = DB::table('rol_permisos')
                        ->select(DB::raw(' rol_permisos.id,rol_permisos.estado, permisos.nombrePermiso, rols.nombreRol'))
                        ->join('permisos','rol_permisos.permisoId','=','permisos.id')
                        ->join('rols','rol_permisos.rolId','=','rols.id')->get();
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
    
}
