<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VentaEncabezado;
use Illuminate\Support\Facades\Auth;
use App\DetalleVenta;

class VentasController extends Controller
{
    public function store(Request $req){
        try {
            $encabezado = new VentaEncabezado;
            $encabezado->total = $req->total;
            $encabezado->totalSinIVA = $req->subtotal;
            $encabezado->iva = $req->total - $req->subtotal;
            $encabezado->serie = 5;
            $encabezado->cheque = "1235";
            $encabezado->numeroFactura = 5;
            $encabezado->idPersona = $req->idCliente;
            $encabezado->idEmpleado = Auth::user()->id;;
            $encabezado->idTipoPago = 1;
            $encabezado->save();
            
            $detalles = $req->carrito;
            foreach($req->carrito as $det){
                $detalle = new Detalle;
                $detalle->cantidad = $det->cantidad;
                $detalle->subtotal = $det->sub;
                $detalle->idProducto = $det->idProd;
                $detalle->idVentaEncabezado = $encabezado->id;
                $detalle->save();
            }
            return "Venta realizada correctamente";
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
}
