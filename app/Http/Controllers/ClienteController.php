<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Persona;

class ClienteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 
    
    public function index(Request $request){
        if(!$request->ajax())
            return redirect('/home');
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
                    ->where('clientes.estado','=',true)
                    ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('clientes.general', compact('clientes'));
        return $pdf->stream('clientes.pdf');
    }
    public function total(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $total = DB::table('clientes')
                ->select(DB::raw('COUNT(clientes.id) as total'))
                ->where('clientes.estado','=',true)
                ->get();
        return $total;
    }
    public function mayorComprador(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $cliente = DB::table('venta_encabezados')
                    ->select(DB::raw('clientes.nombreCliente, COUNT(venta_encabezados.idPersona) as total'))
                    ->join('clientes','clientes.idPersona','=','venta_encabezados.idPersona')
                    ->where('clientes.estado','=',1)
                    ->groupBy('venta_encabezados.idPersona','clientes.nombreCliente')
                    ->orderBy('total','desc')
                    ->limit(1)
                    ->get();
        return $cliente;
    }
}
