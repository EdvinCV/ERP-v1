<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Proveedor;
use App\Persona;


class ProveedorController extends Controller
{
    public function index(){
        $proveedores = DB::table('proveedors')
                        ->join('personas','personas.id','=','proveedors.idPersona')
                        ->where('proveedors.estado','=',true)
                        ->get();
        return $proveedores;
    }

    public function store(Request $req){
        try {
            $persona = new Persona;
            $persona->nombre = $req->nombre;
            $persona->apellido = $req->apellido;
            $persona->direccion = $req->direccion;
            $persona->telefono = $req->telefono;
            $persona->nit = $req->nit;
            $persona->correo = $req->correo;
            $persona->save();
            $idP = $persona->id;

            $prov = new Proveedor;
            $prov->idPersona = $idP;
            $prov->nombreProveedor = $req->nombreProveedor;
            $prov->save();
            return 'Proveedor ingresado correctamente';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function update(Request $req){
        try {
            $id = $req->id;
            $persona=Persona::findOrFail($id);
            $persona->nombre = $req->nombre;
            $persona->apellido = $req->apellido;
            $persona->direccion = $req->direccion;
            $persona->telefono = $req->telefono;
            $persona->nit = $req->nit;
            $persona->correo = $req->correo;
            $persona->save();
            $prov = Proveedor::where('idPersona', '=', $id)->firstOrFail();
            $prov->nombreProveedor = $req->nombreProveedor;
            $prov->save();
            return 'Proveedor actualizado correctamente';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function desactivar(Request $req){
        try {
            $prov = Proveedor::where('idPersona','=', $req->id)->firstOrFail();
            $prov->estado = false;
            $prov->save();
            return 'Eliminado correctamente';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
        
    }
    
}
