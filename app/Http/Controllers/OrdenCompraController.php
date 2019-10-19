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
    public function __construct(){
        $this->middleware('auth');
    } 
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
                    ->select('totalCompra')
                    ->where('id','=',$id)
                    ->get();

        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.orden', compact('clientes', 'productos', 'id', 'prodsClientes','total'));
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
                $prod->existencia = $prod->existencia + $d['cantidad']; 
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
                
            }
            $impuestos = ($totalVenta / 1.12) *0.19;
            $utilidadVenta = $totalVenta - $totalCompra - $impuestos;
            $encabezado = CompraEncabezado::find($req->orden);
            $encabezado->totalCompra = $totalCompra;
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

        $total = DB::table('compra_encabezados')
                    ->select('totalCompra')
                    ->where('id','=',$id)
                    ->get();

        
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.ordenFinalizada', compact('orden','clientes', 'productos', 'id', 'prodsClientes','total'));
        return $pdf->stream('ordenCompra.pdf');

    }
    public function validarTotal(){
        $total = DB::table('compra_encabezados')
            ->select(DB::raw('SUM(compra_encabezados.totalCompra) as Total'))
            ->whereRaw('DATE_FORMAT(compra_encabezados.created_at,"%y-%m-%d") = curdate()')
            ->where('compra_encabezados.finalizado','=','1')
            ->get();
        return $total;
    }
    public function reporteGeneral(Request $req){
        $fechaDe = $req->date1;
        $fechaA = $req->date2;
        $encabezados = DB::table('compra_encabezados')
                        ->select('compra_encabezados.totalCompra', 'compra_encabezados.gastosParqueo', 'compra_encabezados.combustible',
                        'compra_encabezados.gastosVarios', 'compra_encabezados.impuestos', 'compra_encabezados.totalVenta', 'compra_encabezados.utilidadVenta')
                        ->whereBetween('compra_encabezados.created_at',[$fechaDe, $fechaA])
                        ->where('compra_encabezados.finalizado','=','1')
                        ->get();
        $total = DB::table('compra_encabezados')
                    ->select(DB::raw('SUM(compra_encabezados.TotalCompra) as total'))
                    ->whereBetween('compra_encabezados.created_at',[$fechaDe, $fechaA])
                    ->where('compra_encabezados.finalizado','=','1')
                    ->get();
        $parqueo = DB::table('compra_encabezados')
                    ->select(DB::raw('SUM(compra_encabezados.gastosParqueo) as parqueo'))
                    ->whereBetween('compra_encabezados.created_at',[$fechaDe, $fechaA])
                    ->where('compra_encabezados.finalizado','=','1')
                    ->get();
        $combustible = DB::table('compra_encabezados')
                    ->select(DB::raw('SUM(compra_encabezados.combustible) as combustible'))
                    ->whereBetween('compra_encabezados.created_at',[$fechaDe, $fechaA])
                    ->where('compra_encabezados.finalizado','=','1')
                    ->get();
        $varios = DB::table('compra_encabezados')
                    ->select(DB::raw('SUM(compra_encabezados.gastosVarios) as varios'))
                    ->whereBetween('compra_encabezados.created_at',[$fechaDe, $fechaA])
                    ->where('compra_encabezados.finalizado','=','1')
                    ->get();    
        $impuestos = DB::table('compra_encabezados')
                    ->select(DB::raw('SUM(compra_encabezados.impuestos) as impuestos'))
                    ->whereBetween('compra_encabezados.created_at',[$fechaDe, $fechaA])
                    ->where('compra_encabezados.finalizado','=','1')
                    ->get();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.comprasgeneral', compact('encabezados','total', 'parqueo', 'combustible', 'varios','impuestos'));
        return $pdf->stream('ComprasGeneral.pdf');                    

    }
    public function obtenerComprasSemana(){
        $year = date('Y');
        $month = date('n');
        $day = date('j');
        $semana=date("W",mktime(0,0,0,$month,$day,$year));
        $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
        if($diaSemana==0)
            $diaSemana=7;
        $primerDia=date("Y-m-d",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
        $ultimoDia=date("Y-m-d",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
        
        $totalVentas = DB::table('compra_encabezados')
                        ->select(DB::raw('SUM(compra_encabezados.totalCompra) as total'))
                        ->whereBetween('compra_encabezados.created_at',[$primerDia, $ultimoDia])
                        ->where('compra_encabezados.finalizado','=','1')
                        ->get();
        return $totalVentas;
    }
    public function obtenerComprasDia(){
        $hoy = getDate();
        $fecha1 = strval($hoy['year']).'/'.strval($hoy['mon']).'/'.strval($hoy['mday']);
        $fecha2 = $hoy['year'].'/'.$hoy['mon'].'/'.strval($hoy['mday']+1);
        $ventasDia = DB::table('compra_encabezados')
                    ->select(DB::raw('sum(compra_encabezados.totalCompra) as dia'))
                    ->whereBetween('compra_encabezados.created_at',[$fecha1, $fecha2])
                    ->where('compra_encabezados.finalizado','=','1')
                    ->get();

        return $ventasDia;
    }
    public function pendientes(){
        $ventasDia = DB::table('compra_encabezados')
                    ->select(DB::raw('COUNT(compra_encabezados.id) as pendientes'))
                    ->where('compra_encabezados.finalizado','!=','1')
                    ->get();
        return $ventasDia;

    }
}
