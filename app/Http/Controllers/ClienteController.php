<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Persona;

class ClienteController extends Controller
{
    public function index(){
        $proveedores = DB::table('clientes')
                        ->join('personas','personas.id','=','clientes.idPersona')
                        ->where('clientes.estado','=',true)
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
            $cliente = new Cliente;
            $cliente->idPersona = $idP;
            $cliente->dpi = $req->dpi;
            $cliente->nombreCliente = $req->nombreCliente;
            $cliente->save();
            return 'Cliente ingresado correctamente';
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
            $cliente = Cliente::where('idPersona', '=', $id)->firstOrFail();
            $cliente->nombreCliente = $req->nombreCliente;
            $cliente->dpi = $req->dpi;
            $cliente->save();
            return 'Cliente actualizado correctamente';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function desactivar(Request $req){
        try {
            $c = Cliente::where('idPersona','=', $req->id)->firstOrFail();
            $c->estado = false;
            $c->save();
            return 'Eliminado correctamente';
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
        
    }
    public function reporteGeneral(){
        $clientes = DB::table('clientes')
                    ->join('personas','personas.id','=','clientes.idPersona')
                    ->where('personas.estado','=',true)
                    ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('clientes.general', compact('clientes'));
        return $pdf->stream('clientes.pdf');
    }
}
