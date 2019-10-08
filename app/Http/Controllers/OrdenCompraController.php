<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompraEncabezado;
use App\CompraDetalle;
use App\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrdenCompraController extends Controller
{
    //
    public function index(){
        $finalizadas = DB::table('compra_encabezados')
                        ->get();
        return $finalizadas;
    }
    public function detalles(){
        $detalles = DB::table('compra_detalles')
                    ->select('compra_detalles.id','productos.id as idp','productos.nombre as producto', 'presentacions.nombre as presentacion', 'proveedors.nombreProveedor', 'productos.precioCompra', DB::raw('SUM(compra_detalles.cantidad) as cantidad'), 'proveedors.idPersona', 'compra_detalles.idCompraEncabezado', 'clientes.nombreCliente', 'compra_detalles.id as idC')
                    ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idpersona')
                    ->join('clientes', 'clientes.idPersona', '=', 'compra_detalles.idPersona')
                    ->groupBy('productos.id', 'productos.nombre', 'presentacions.nombre', 'proveedors.nombreProveedor', 'productos.precioCompra', 'proveedors.idPersona', 'compra_detalles.idCompraEncabezado', 'clientes.nombreCliente', 'compra_detalles.id')
                    ->get();
        return $detalles;
    }
    public function indexGenerales(){
        $detalles = DB::table('compra_detalles')
                    ->select('productos.id','productos.nombre as producto', 'presentacions.nombre as presentacion', 'proveedors.nombreProveedor', 'productos.precioCompra', DB::raw('SUM(compra_detalles.cantidad) as cantidad'), 'proveedors.idPersona', 'compra_detalles.idCompraEncabezado', 'clientes.nombreCliente', 'compra_detalles.id as idC')
                    ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idpersona')
                    ->join('clientes', 'clientes.idPersona', '=', 'compra_detalles.idPersona')
                    ->get();
        return $detalles;
    }
    public function generarOrden(Request $req){
        //Este método genera el pdf de la orden de compra y guarda los elementos en una tabla.
        try {
            $compra = new CompraEncabezado;
            $compra->idEncargado = $req->idEncargado;
            $compra->idEmpleado = Auth::user()->id;
            $compra->observaciones = '';
            $compra->totalCompra = $req->total;
            $compra->save();

            $detalles = $req->input('carrito');
             
            foreach($detalles as $d){
                $det = new CompraDetalle;
                $det->idProducto = $d['idProd'];
                $det->cantidad = $d['cantidad'];
                $det->precioCompra = $d['precio'];
                $det->totalCompra = $d['cantidad'] * $d['precio'];
                $det->precioVenta = $d['venta'];
                $det->totalVenta = $d['venta'] * $d['cantidad'];
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
                    ->select('clientes.nombreCliente', 'clientes.idPersona')
                    ->join('clientes', 'clientes.idPersona', '=', 'compra_detalles.idPersona')
                    ->where('idCompraEncabezado', '=', $id)
                    ->groupBy('nombreCliente', 'idPersona')
                    ->get();
            
        $productos = DB::table('compra_detalles')
                    ->select('productos.id','productos.nombre as producto', 'presentacions.nombre as presentacion', 'proveedors.nombreProveedor', 'productos.preciocompra', DB::raw('SUM(compra_detalles.cantidad) as cantidad'), 'proveedors.idPersona')
                    ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idpersona')
                    ->where('idCompraEncabezado', '=', $id)
                    ->groupBy('productos.id', 'productos.nombre', 'presentacions.nombre', 'proveedors.nombreProveedor', 'productos.preciocompra', 'proveedors.idPersona')
                    ->get();

        $prodsClientes = DB::table('compra_detalles')
                            ->select('productos.nombre as producto', 'compra_detalles.cantidad as cantidad', 'compra_detalles.idPersona', 'presentacions.nombre as presentacion')
                            ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                            ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idpersona')
                            ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                            ->where('idCompraEncabezado', '=', $id)
                            ->get();
        
        $total = DB::table('compra_encabezados')
                    ->get();

        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.orden', compact('total','clientes', 'productos', 'id', 'prodsClientes'));
        return $pdf->stream('ordenCompra.pdf');
    }
    public function finalizarOrden(Request $req){
        try {
            //Inicialización de variables
            $totalCompra = 0;
            $totalVenta = 0;
            $impuestos = 0;
            //Obtener el número de orden
            $id = $req->orden;
            //Buscar la orden
            $orden=CompraEncabezado::findOrFail($id);
            $orden->gastosParqueo = $req->parqueo; 
            $orden->combustible = $req->combustible;
            $orden->gastosVarios = $req->gastosVarios;
            $orden->observaciones = $req->observaciones;
            $orden->finalizado = 1;
            
            $detalles = $req->input('detalles');
            foreach($detalles as $d){
                $prod = Producto::find($d['idp']);
                $prod->precioCompra = $d['precioCompra'];
                $totalCompra += $d['precioCompra'] * $d['cantidad'];
                $totalVenta += $prod->precioventa * $d['cantidad'];
                $prod->save();
            }
            //Calculos
            $orden->totalCompra = $totalCompra; 
            $orden->totalVenta = $totalVenta;
            $impuestos = ($totalVenta / 1.12) *0.19;
            $orden->utilidadVenta = $totalVenta - $totalCompra - $impuestos;
            $orden->impuestos = $impuestos;
            $orden->save();
            return "Orden finalizada correctamente";
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function editarOrden(Request $req){
        try {
            $totalCompra = 0;
            $totalVenta = 0;
            $impuestos = 0;
            $utilidadVenta = 0;
            //Agregar detalles.
            $detalles = $req->input('detalles');
            foreach($detalles as $d){
                if($d['id'] == 0){
                    $det = new CompraDetalle;
                    $det->idProducto = $d['idp'];
                    $det->cantidad = $d['cantidad'];
                    $prod = Producto::find($d['idp']);
                    $det->precioCompra = $prod->preciocompra;
                    $det->totalCompra = $d['cantidad'] * $prod->preciocompra;
                    $det->precioVenta = $prod->precioventa;
                    $det->totalVenta = $prod->precioventa * $d['cantidad'];
                    $det->idCompraEncabezado = $req->orden;
                    $det->idPersona = $d['cliente'];
                    $det->save();
                }
            }
            //Elimina detalles.
            $detalles = $req->input('detallesEliminados');
            if(!$detalles == ''){
                foreach($detalles as $d){
                    $detalle=CompraDetalle::findOrFail($d['idDetalle']);
                    $detalle->delete();
                }
            }
            //Recalcula campos de encabezado.
            $detallesCompra = DB::table('compra_detalles')
                            ->where('id', '=', $req->orden)
                            ->get();
            foreach($detallesCompra as $d){
                $totalCompra += $d->precioCompra * $d->cantidad;
                $totalVenta += $d->precioVenta * $d->cantidad;
            }
            $impuestos = ($totalVenta / 1.12) *0.19;
            $utilidadVenta = $totalVenta - $totalCompra - $impuestos;
            $encabezado = CompraEncabezado::find($req->orden);
            $encabezado->totalCompra = $totalCompra;
            $encabezado->totalVenta = $totalVenta;
            $encabezado->impuestos = $impuestos;
            $encabezado->utilidadVenta = $utilidadVenta;
            $encabezado->save();
            
            return "Orden modificada correctamente.";

        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function drop(CompraEncabezado $id){
        try{   
            DB::table('compra_detalles')->where('idCompraEncabezado','=',$id->id)->delete();
            $id->delete();
            return 'Compra eliminada correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function ordenFinalizada($id){
        $clientes = DB::table('compra_detalles')
                    ->select('clientes.nombreCliente', 'clientes.idPersona')
                    ->join('clientes', 'clientes.idPersona', '=', 'compra_detalles.idPersona')
                    ->where('idCompraEncabezado', '=', $id)
                    ->groupBy('nombreCliente', 'idPersona')
                    ->get();
            
        $productos = DB::table('compra_detalles')
                    ->select('productos.id','productos.nombre as producto', 'presentacions.nombre as presentacion', 'proveedors.nombreProveedor', 'productos.preciocompra', DB::raw('SUM(compra_detalles.cantidad) as cantidad'), 'proveedors.idPersona')
                    ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idpersona')
                    ->where('idCompraEncabezado', '=', $id)
                    ->groupBy('productos.id', 'productos.nombre', 'presentacions.nombre', 'proveedors.nombreProveedor', 'productos.preciocompra', 'proveedors.idPersona')
                    ->get();

        $prodsClientes = DB::table('compra_detalles')
                            ->select('productos.nombre as producto', 'compra_detalles.cantidad as cantidad', 'compra_detalles.idPersona', 'presentacions.nombre as presentacion')
                            ->join('productos', 'productos.id', '=', 'compra_detalles.idProducto')
                            ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idpersona')
                            ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                            ->where('idCompraEncabezado', '=', $id)
                            ->get();
        
        $orden = DB::table('compra_encabezados')
                    ->where('compra_encabezados.id','=',$id)
                    ->get();

        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.ordenFinalizada', compact('orden','clientes', 'productos', 'id', 'prodsClientes'));
        return $pdf->stream('ordenCompra.pdf');

    }
}
