<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VentaEncabezado;
use Illuminate\Support\Facades\Auth;
use App\DetalleVenta;
use App\Producto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 
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
                $prod=Producto::find($d['idProd']);
                $prod->existencia = $prod->existencia - $d['cantidad'];
                $prod->save(); 
                $det = new DetalleVenta;
                $det->subtotal = $d['sub'];
                $det->cantidad = $d['cantidad'];     
                $det->idProducto = $d['idProd'];
                $det->precioventa = $d['precio'];
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
    public function cotizacion(Request $req){
        if(!$req->ajax())
            return redirect('/home');
        $detalles = $req->input('carrito');
        $total = $req->total;  
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('ventas.cotizacion', compact('detalles','total'));
        return $pdf->download('factura.pdf');
    }
    public function listarVentas(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $ventas = DB::table('venta_encabezados')
                        ->select('venta_encabezados.id', 'clientes.nombreCliente', 'venta_encabezados.total', 'venta_encabezados.created_at', 'facturado', 'numeroFactura')
                        ->join('personas', 'personas.id', '=', 'venta_encabezados.idPersona')
                        ->join('clientes', 'clientes.idPersona', '=', 'venta_encabezados.idPersona')
                        ->get();   
        return $ventas;
    }
    public function validarTotal(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $total = DB::table('venta_encabezados')
            ->select(DB::raw('SUM(venta_encabezados.total) as Total'))
            ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
            ->whereRaw('DATE_FORMAT(venta_encabezados.created_at,"%y-%m-%d") = curdate()')
            ->where('tipo_pagos.nombreTipo','=','Efectivo')
            ->get();
        return $total;
    }
    public function drop(VentaEncabezado $id){
        try{
            DB::table('detalle_ventas')->where('idVentaEncabezado','=',$id->id)->delete();
            $id->delete();
            return 'Venta eliminada correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function detalleVenta(Request $request){
        if(!$request->ajax()) 
            return redirect('/home');
        $id = $request->ventaEncabezado;
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
    public function generarFactura(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $id = $request->venta;
        $ventas = DB::table('venta_encabezados')
                    ->select(DB::raw('clientes.nombreCliente ,personas.direccion , personas.nit, DATE_FORMAT(venta_encabezados.created_at, "%d-%m-%Y") as fecha, venta_encabezados.total'))
                    ->join('tipo_pagos','tipo_pagos.id','=','venta_encabezados.idTipoPago')
                    ->join('clientes', 'clientes.idPersona', '=', 'venta_encabezados.idPersona')
                    ->join('personas', 'personas.id', '=', 'venta_encabezados.idPersona')
                    ->where('venta_encabezados.id', '=', $id)
                    ->get();
    
        $detalles = DB::table('detalle_ventas')
                    ->select('productos.nombre as producto', 'presentacions.nombre as presentacion', 'detalle_ventas.cantidad', 'productos.precioventa as precio', 'detalle_ventas.subtotal', 'detalle_ventas.precioventa', 'proveedors.nombreProveedor')
                    ->join('productos', 'productos.id', '=', 'detalle_ventas.idProducto')
                    ->join('presentacions', 'presentacions.id', '=', 'productos.idpresentacion')
                    ->join('proveedors', 'proveedors.idPersona', '=', 'productos.idPersona')
                    ->where('detalle_ventas.idVentaEncabezado', '=', $id)
                    ->get();

        $total = DB::table('venta_encabezados')
                    ->select('venta_encabezados.total')
                    ->where('venta_encabezados.id', '=', $id)
                    ->get();
        $totalLetras = $this->convertir($total[0]->total);
                
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('ventas.factura', compact('ventas', 'detalles','totalLetras'));
        return $pdf->stream('factura.pdf');
    }
    public function reporteVentasProducto(Request $req){
        if(!$req->ajax())
            return redirect('/home');
        $fechaDe = $req->date3;
        $fechaA =  $req->date4;
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

        $total = DB::table('detalle_ventas')
                    ->select(DB::raw('SUM(subtotal) AS total'))
                    ->whereBetween('detalle_ventas.created_at', [$fechaDe, $fechaA])
                    ->get();
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('reportes.VentasProductos', compact('productos','total'));
        return $pdf->stream('VentasPorProducto.pdf');
    }
    public function reporteVentasClientes(Request $req){
        if(!$req->ajax())
            return redirect('/home');
        $fechaDe = $req->date1;
        $fechaA = $req->date2;
        $idCliente = $req->idCliente;
        
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
    public function obtenerVentasSemana(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $year = date('Y');
        $month = date('n');
        $day = date('j');
        $semana=date("W",mktime(0,0,0,$month,$day,$year));
        $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
        if($diaSemana==0)
            $diaSemana=7;
        $primerDia=date("Y-m-d",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
        $ultimoDia=date("Y-m-d",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
        
        $totalVentas = DB::table('venta_encabezados')
                        ->select(DB::raw('SUM(totalSinIVA) as total'))
                        ->whereBetween('venta_encabezados.created_at',[$primerDia, $ultimoDia])
                        ->get();

        return $totalVentas;
    }
    public function obtenerVentasDia(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $hoy = getDate();
 
        $fecha1 = strval($hoy['year']).'/'.strval($hoy['mon']).'/'.strval($hoy['mday']);
        $fecha2 = $hoy['year'].'/'.$hoy['mon'].'/'.strval($hoy['mday']+1);
        $ventasDia = DB::table('venta_encabezados')
                    ->select(DB::raw('SUM(totalSinIVA) as dia'))
                    ->whereBetween('venta_encabezados.created_at',[$fecha1, $fecha2])
                    ->get();

        return $ventasDia;
    }
    public function productoMasVendido(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $producto = DB::table('productos')
                    ->select(DB::raw('productos.nombre as producto, presentacions.nombre, nombreProveedor, SUM(cantidad) as total'))
                    ->join('presentacions','presentacions.id','=','productos.idpresentacion')
                    ->join('proveedors','proveedors.idPersona','=','productos.idPersona')
                    ->join('detalle_ventas','detalle_ventas.idProducto','=','productos.id')
                    ->groupBy('productos.id','productos.nombre','presentacions.nombre','nombreProveedor')
                    ->orderBy('total','desc')
                    ->limit(1)
                    ->get();

        return $producto;
    }
    public function productoMenosVendido(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $producto = DB::table('productos')
        ->select(DB::raw('productos.nombre as producto, presentacions.nombre, nombreProveedor, SUM(cantidad) as total'))
        ->join('presentacions','presentacions.id','=','productos.idpresentacion')
        ->join('proveedors','proveedors.idPersona','=','productos.idPersona')
        ->join('detalle_ventas','detalle_ventas.idProducto','=','productos.id')
        ->groupBy('productos.id','productos.nombre','presentacions.nombre','nombreProveedor')
        ->orderBy('total','asc')
        ->limit(1)
        ->get();

        return $producto;
    }
    public function productoMasGanancia(Request $request){
        if(!$request->ajax())
            return redirect('/home');
        $producto = DB::table('detalle_ventas')
                        ->select(DB::raw('productos.nombre, SUM(detalle_ventas.subtotal) as total'))
                        ->join('productos','productos.id','=','detalle_ventas.idProducto')
                        ->join('proveedors','proveedors.idPersona','=','productos.id')
                        ->groupBy('productos.id','productos.nombre')
                        ->orderBy('total','desc')
                        ->limit(1)
                        ->get();
        return $producto;
    }
    function unidad($numuero){
        switch ($numuero)
        {
            case 9:
            {
                $numu = "NUEVE";
                break;
            }
            case 8:
            {
                $numu = "OCHO";
                break;
            }
            case 7:
            {
                $numu = "SIETE";
                break;
            }
            case 6:
            {
                $numu = "SEIS";
                break;
            }
            case 5:
            {
                $numu = "CINCO";
                break;
            }
            case 4:
            {
                $numu = "CUATRO";
                break;
            }
            case 3:
            {
                $numu = "TRES";
                break;
            }
            case 2:
            {
                $numu = "DOS";
                break;
            }
            case 1:
            {
                $numu = "UNO";
                break;
            }
            case 0:
            {
                $numu = "";
                break;
            }
        }
                return $numu;
            }
    
    function decena($numdero){
    
        if ($numdero >= 90 && $numdero <= 99)
        {
            $numd = "NOVENTA ";
        
            if ($numdero > 90)
                $numd = $numd."Y ".($this->unidad($numdero - 90));
        }
        else if ($numdero >= 80 && $numdero <= 89)
        {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd."Y ".($this->unidad($numdero - 80));
        }
        else if ($numdero >= 70 && $numdero <= 79)
        {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd."Y ".($this->unidad($numdero - 70));
        }
        else if ($numdero >= 60 && $numdero <= 69)
        {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd."Y ".($this->unidad($numdero - 60));
        }
        else if ($numdero >= 50 && $numdero <= 59)
        {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd."Y ".($this->unidad($numdero - 50));
        }
        else if ($numdero >= 40 && $numdero <= 49)
        {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd."Y ".($this->unidad($numdero - 40));
        }
        else if ($numdero >= 30 && $numdero <= 39)
        {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd."Y ".($this->unidad($numdero - 30));
        }
        else if ($numdero >= 20 && $numdero <= 29)
        {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI".($this->unidad($numdero - 20));
        }
        else if ($numdero >= 10 && $numdero <= 19)
        {
            switch ($numdero){
                case 10:
                {
                    $numd = "DIEZ ";
                    break;
                }
                case 11:
                {
                    $numd = "ONCE ";
                    break;
                }
                case 12:
                {
                    $numd = "DOCE ";
                    break;
                }
                case 13:
                {
                    $numd = "TRECE ";
                    break;
                }
                case 14:
                {
                    $numd = "CATORCE ";
                    break;
                }
                case 15:
                {
                    $numd = "QUINCE ";
                    break;
                }
                case 16:
                {
                    $numd = "DIECISEIS ";
                    break;
                }
                case 17:
                {
                    $numd = "DIECISIETE ";
                    break;
                }
                case 18:
                {
                    $numd = "DIECIOCHO ";
                    break;
                }
                case 19:
                {
                    $numd = "DIECINUEVE ";
                    break;
                }
            }
        }else
            $numd = unidad($numdero);
            
            return $numd;
    }
    function centena($numc){
        if ($numc >= 100)
        {
        if ($numc >= 900 && $numc <= 999)
        {
        $numce = "NOVECIENTOS ";
        if ($numc > 900)
        $numce = $numce.($this->decena($numc - 900));
        }
        else if ($numc >= 800 && $numc <= 899)
        {
        $numce = "OCHOCIENTOS ";
        if ($numc > 800)
        $numce = $numce.($this->decena($numc - 800));
        }
        else if ($numc >= 700 && $numc <= 799)
        {
        $numce = "SETECIENTOS ";
        if ($numc > 700)
        $numce = $numce.($this->decena($numc - 700));
        }
        else if ($numc >= 600 && $numc <= 699)
        {
        $numce = "SEISCIENTOS ";
        if ($numc > 600)
        $numce = $numce.($this->decena($numc - 600));
        }
        else if ($numc >= 500 && $numc <= 599)
        {
        $numce = "QUINIENTOS ";
        if ($numc > 500)
        $numce = $numce.($this->decena($numc - 500));
        }
        else if ($numc >= 400 && $numc <= 499)
        {
        $numce = "CUATROCIENTOS ";
        if ($numc > 400)
        $numce = $numce.($this->decena($numc - 400));
        }
        else if ($numc >= 300 && $numc <= 399)
        {
        $numce = "TRESCIENTOS ";
        if ($numc > 300)
        $numce = $numce.($this->decena($numc - 300));
        }
        else if ($numc >= 200 && $numc <= 299)
        {
        $numce = "DOSCIENTOS ";
        if ($numc > 200)
        $numce = $numce.($this->decena($numc - 200));
        }
        else if ($numc >= 100 && $numc <= 199)
        {
        if ($numc == 100)
        $numce = "CIEN ";
        else
        $numce = "CIENTO ".($this->decena($numc - 100));
        }
        }
        else
        $numce = $this->decena($numc);
        
        return $numce;
    }
    function miles($nummero){
        if ($nummero >= 1000 && $nummero < 2000){
        $numm = "MIL ".($this->centena($nummero%1000));
        }
        if ($nummero >= 2000 && $nummero <10000){
        $numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000));
        }
        if ($nummero < 1000)
        $numm = $this->centena($nummero);
        
        return $numm;
    }
    function decmiles($numdmero){
        if ($numdmero == 10000)
        $numde = "DIEZ MIL";
        if ($numdmero > 10000 && $numdmero <20000){
        $numde = $this->decena(Floor($numdmero/1000))."MIL ".($this->centena($numdmero%1000));
        }
        if ($numdmero >= 20000 && $numdmero <100000){
        $numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));
        }
        if ($numdmero < 10000)
        $numde = $this->miles($numdmero);
        
        return $numde;
    }
    function cienmiles($numcmero){
        if ($numcmero == 100000)
        $num_letracm = "CIEN MIL";
        if ($numcmero >= 100000 && $numcmero <1000000){
        $num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000));
        }
        if ($numcmero < 100000)
        $num_letracm = $this->decmiles($numcmero);
        return $num_letracm;
    }
    function millon($nummiero){
        if ($nummiero >= 1000000 && $nummiero <2000000){
        $num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000));
        }
        if ($nummiero >= 2000000 && $nummiero <10000000){
        $num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000));
        }
        if ($nummiero < 1000000)
        $num_letramm = $this->cienmiles($nummiero);
        
        return $num_letramm;
    }
    function decmillon($numerodm){
        if ($numerodm == 10000000)
        $num_letradmm = "DIEZ MILLONES";
        if ($numerodm > 10000000 && $numerodm <20000000){
        $num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ".($this->cienmiles($numerodm%1000000));
        }
        if ($numerodm >= 20000000 && $numerodm <100000000){
        $num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));
        }
        if ($numerodm < 10000000)
        $num_letradmm = $this->millon($numerodm);
        
        return $num_letradmm;
    }
    function cienmillon($numcmeros){
        if ($numcmeros == 100000000)
        $num_letracms = "CIEN MILLONES";
        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
        $num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000));
        }
        if ($numcmeros < 100000000)
        $num_letracms = $this->decmillon($numcmeros);
        return $num_letracms;
    }  
    function milmillon($nummierod){
        if ($nummierod >= 1000000000 && $nummierod <2000000000){
        $num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod <10000000000){
        $num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000));
        }
        if ($nummierod < 1000000000)
        $num_letrammd = $this->cienmillon($nummierod);
        
        return $num_letrammd;
    }
    function convertir($numero){
        $num = str_replace(",","",$numero);
        $num = number_format($num,2,'.','');
        $cents = substr($num,strlen($num)-2,strlen($num)-1);
        $num = (int)$num;
        
        $numf = $this->milmillon($num);
        
        return $numf." QUETZALES CON ".$cents."/100";
    }

}
