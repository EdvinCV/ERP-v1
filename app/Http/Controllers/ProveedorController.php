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
    public function prov(){
        $prov = DB::table('proveedors')
                    ->select(DB::raw('proveedors.nombreProveedor, COUNT(productos.id) as total'))
                    ->join('productos','productos.idpersona','=','proveedors.idPersona')
                    ->groupBy('productos.idPersona','proveedors.nombreProveedor')
                    ->orderBy('total','desc')
                    ->limit(1)
                    ->get();
        return $prov;
    }
    public function reporteGeneral(){
        $proveedores = DB::table('proveedors')
                        ->select(DB::raw('COUNT(productos.idPersona) as productos, nombreProveedor, direccion, nit, telefono, proveedors.idPersona'))
                        ->join('personas','personas.id','=','proveedors.idPersona')
                        ->join('productos','productos.idpersona','=','proveedors.idPersona')
                        ->where('proveedors.estado','=',true)
                        ->orderBy('productos','desc')
                        ->groupBy('productos.idPersona','nombreProveedor','direccion','telefono','nit','proveedors.idPersona')
                        ->get();
        
        $prodsProveedores = DB::table('productos')
                        ->select('productos.nombre as producto', 'presentacions.nombre as presentacion','productos.idPersona')
                        ->join('presentacions','presentacions.id','=','productos.idpresentacion')
                        ->get();
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('proveedores.general', compact('proveedores','prodsProveedores'));
        return $pdf->stream('proveedores.pdf'); 
    }
    public function reporteEspecifico($id){
        $proveedor = DB::table('proveedors')
                        ->where('proveedors.idPersona','=',$id)
                        ->get();
        $prodsProveedor = DB::table('productos')
                        ->select(DB::raw('productos.nombre, presentacions.nombre as presentacion, productos.id'))
                        ->join('presentacions','presentacions.id','=','productos.idpresentacion')
                        ->where('productos.idPersona','=',$id)
                        ->get();
                    
        $historial = DB::table('historialcalidads')
                        ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('proveedores.especifico', compact('proveedor','prodsProveedor','historial'));
        return $pdf->stream('proveedores.pdf'); 
    }   
}
