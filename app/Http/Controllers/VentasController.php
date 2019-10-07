<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VentaEncabezado;
use Illuminate\Support\Facades\Auth;
use App\DetalleVenta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentasController extends Controller
{
    public function store(Request $req){
        try {
            $encabezado = new VentaEncabezado;
            $encabezado->total = $req->total;
            $encabezado->totalSinIVA = $req->subtotal;
            $encabezado->iva = $req->total - $req->subtotal;
            $encabezado->serie = 5;
            $encabezado->cheque = $req->cheque;
            $encabezado->banco = $req->banco;
            $encabezado->numeroFactura = $req->numFact;
            $encabezado->facturado = $req->switchFact;
            $encabezado->idPersona = $req->idCliente;
            $encabezado->idEmpleado = Auth::user()->id;
            if($req->radios == 'efectivo')
                $encabezado->idTipoPago = 1;
            else 
                $encabezado->idTipoPago = 2;
            $encabezado->save();

            $detalles = $req->input('carrito');
             
            foreach($detalles as $d){
                $det = new DetalleVenta;
                $det->subtotal = $d['sub'];
                $det->cantidad = $d['cantidad'];     
                $det->idProducto = $d['idProd'];
                $det->descuento = $d['descuento'];
                $det->idVentaEncabezado = $encabezado->id;
                $det->save();
            }

            //FACTURA
            
            $ventas = DB::table('venta_encabezados')
                ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
                ->join('clientes', 'clientes.idPersona', '=', 'venta_encabezados.idPersona')
                ->join('personas', 'personas.id', '=', 'venta_encabezados.idPersona')
                ->where('venta_encabezados.id', '=', $encabezado->id)
                ->get();
            
                $detalles = DB::table('detalle_ventas')
                ->select('productos.nombre as producto', 'presentacions.nombre as presentacion', 'detalle_ventas.cantidad', 'productos.precioventa as precio', 'detalle_ventas.subtotal', 'proveedors.nombreProveedor')
                ->join('productos', 'productos.id', '=', 'detalle_ventas.idProducto')
                ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idPersona')
                ->where('detalle_ventas.idVentaEncabezado', '=', $encabezado->id)
                ->get();

                return $encabezado->id;
                
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function listarVentas(){
        $ventas = DB::table('venta_encabezados')
                        ->select('venta_encabezados.id', 'clientes.nombreCliente', 'venta_encabezados.total', 'venta_encabezados.created_at', 'facturado', 'numeroFactura')
                        ->join('personas', 'personas.id', '=', 'venta_encabezados.idPersona')
                        ->join('clientes', 'clientes.idPersona', '=', 'venta_encabezados.idPersona')
                        ->get();   

        return $ventas;
    }

    public function validarTotal(){
        $total = DB::table('venta_encabezados')
            ->select(DB::raw('SUM(venta_encabezados.total) as Total'))
            ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
            ->whereRaw('DATE_FORMAT(venta_encabezados.created_at,"%y-%m-%d") = curdate()')
            ->where('tipo_pagos.nombreTipo','=','Efectivo')
            
            
            ->get();
        return $total;
    }
    
    public function drop(VentaEncabezado $venta){
        try{
            
            DB::table('detalle_ventas')->where('idVentaEncabezado','=',$venta->id)->delete();
            
            return 'Venta eliminada correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function detalleVenta($id){

        $ventas = DB::table('venta_encabezados')
                    ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
                    ->join('clientes', 'clientes.idPersona', '=', 'venta_encabezados.idPersona')
                    ->join('personas', 'personas.id', '=', 'venta_encabezados.idPersona')
                    ->where('venta_encabezados.id', '=', $id)
                    ->get();
    
        $detalles = DB::table('detalle_ventas')
                    ->select('productos.nombre as producto', 'presentacions.nombre as presentacion', 'detalle_ventas.cantidad', 'productos.precioventa as precio', 'detalle_ventas.subtotal', 'proveedors.nombreProveedor')
                    ->join('productos', 'productos.id', '=', 'detalle_ventas.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idPersona')
                    ->where('detalle_ventas.idVentaEncabezado', '=', $id)
                    ->get();
                
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('ventas.detalles', compact('ventas', 'detalles'));
        return $pdf->stream('detallesVenta.pdf');
    }

    public function generarFactura($id){

        $ventas = DB::table('venta_encabezados')
                    ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
                    ->join('clientes', 'clientes.idPersona', '=', 'venta_encabezados.idPersona')
                    ->join('personas', 'personas.id', '=', 'venta_encabezados.idPersona')
                    ->where('venta_encabezados.id', '=', $id)
                    ->get();
    
        $detalles = DB::table('detalle_ventas')
                    ->select('productos.nombre as producto', 'presentacions.nombre as presentacion', 'detalle_ventas.cantidad', 'productos.precioventa as precio', 'detalle_ventas.subtotal', 'proveedors.nombreProveedor')
                    ->join('productos', 'productos.id', '=', 'detalle_ventas.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idPersona')
                    ->where('detalle_ventas.idVentaEncabezado', '=', $id)
                    ->get();
                
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('ventas.factura', compact('ventas', 'detalles'));
        return $pdf->stream('factura.pdf');
    }

    public function reporteVentasProducto(){
        $fechaDe = date('2019-10-7');
        $fechaA = date('2019-10-8');
        $productos = DB::table('detalle_ventas')
                    ->select(DB::raw('productos.nombre as producto, presentacions.nombre as presentacion, categorias.nombre as categoria, proveedors.nombreProveedor as proveedor, SUM(subtotal) AS total, SUM(cantidad) AS Cantidad'))
                    ->join('productos','productos.id', '=', 'detalle_ventas.idProducto')
                    ->join('presentacions','presentacions.id','=','productos.idpresentacion')
                    ->join('categorias','categorias.id','=','productos.idcategoria')
                    ->join('proveedors','proveedors.idPersona','=','productos.idPersona')
                    ->whereBetween('detalle_ventas.created_at', [$fechaDe, $fechaA])
                    ->groupBy('productos.id', 'productos.nombre','presentacions.nombre','categorias.nombre','proveedors.nombreProveedor')
                    ->orderBy('total','desc')
                    ->get();
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('reportes.VentasProductos', compact('productos'));
        return $pdf->stream('VentasPorProducto.pdf');
    }

    public function reporteVentasClientes(){
        $fechaDe = date('2019-10-7');
        $fechaA = date('2019-10-8');
        $idCliente = 10;
        
        $cliente = DB::table('venta_encabezados')
                    ->select(DB::raw('SUM(total) as Total, nombreCliente'))
                    ->join('clientes','clientes.idPersona','=','venta_encabezados.idPersona')
                    ->where('venta_encabezados.idPersona','=',$idCliente)
                    ->groupBy('nombreCliente')
                    ->get();
    

        $detallesVentas = DB::table('venta_encabezados')
                    ->select('venta_encabezados.total','venta_encabezados.totalSinIVA','venta_encabezados.iva','venta_encabezados.numeroFactura','nombreTipo','venta_encabezados.created_at','cheque','banco')
                    ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
                    ->where('venta_encabezados.idPersona','=',$idCliente)
                    ->whereBetween('venta_encabezados.created_at',[$fechaDe, $fechaA])
                    ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('reportes.VentasPorCliente', compact('detallesVentas','cliente'));
        return $pdf->stream('VentasPorCliente.pdf');
                
        
    }
}
