<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompraEncabezado;
use App\CompraDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrdenCompraController extends Controller
{
    //
    public function index(){
        $finalizadas = DB::table('compra_encabezados')
                        ->orderBy('finalizado')
                        ->get();
        return $finalizadas;
    }

    public function detalles($id){
        $detalles = DB::table('compra_detalles')
                    ->where('compra_detalles.idCompraEncabezado', '=', $id)
                    ->get();
        return $detalles;
    }
    public function validarTotal()
    {
        $total = DB::table('compra_encabezados')
            ->select(DB::raw('SUM(compra_encabezados.totalCompra) as Total'))
            ->whereRaw('DATE_FORMAT(compra_encabezados.created_at,"%y-%m-%d") = curdate()')
            ->where('compra_encabezados.finalizado','=','1')
            ->get();
        return $total;
    }
    public function generarOrden(Request $req){
        //Este método genera el pdf de la orden de compra y guarda los elementos en una tabla.
        try {
            $compra = new CompraEncabezado;
            $compra->idEncargado = $req->idEncargado;
            $compra->idEmpleado = Auth::user()->id;
            $compra->observaciones = '';
            $compra->save();

            $detalles = $req->input('carrito');
             
            foreach($detalles as $d){
                $det = new CompraDetalle;
                $det->idProducto = $d['idProd'];
                $det->cantidad = $d['cantidad'];     
                $det->idCompraEncabezado = $compra->id;
                $det->idPersona = $d['cliente'];
                $det->save();
            }
            
            return $compra->id;
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function imprimirOrden($id){  
        
        $clientes = DB::table('compra_detalles')
                    ->select('clientes.nombreCliente')
                    ->join('clientes', 'clientes.idPersona', '=', 'compra_detalles.idPersona')
                    ->where('idCompraEncabezado', '=', $id)
                    ->groupBy('nombreCliente')
                    ->get();
            
        $productos = DB::table('compra_detalles')
                    ->select('productos.nombre as producto', 'presentacions.nombre as presentacion', 'clientes.nombreCliente', 'compra_detalles.cantidad')
                    ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('clientes', 'clientes.idPersona', '=', 'compra_detalles.idPersona')
                    ->where('idCompraEncabezado', '=', $id)
                    ->groupBy('productos.nombre', 'presentacions.nombre', 'clientes.nombreCliente', 'compra_detalles.cantidad')
                    ->get();
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.orden', compact('clientes', 'productos'));
        return $pdf->stream('ordenCompra.pdf');
    }
}
