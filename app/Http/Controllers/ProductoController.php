<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\Presentacion;
use App\Categoria;
use App\Persona;
use Carbon\Carbon;
class ProductoController extends Controller
{
    
   public function index(Request $request){
       $producto = DB::table('productos')
                       ->select(DB::raw('productos.id, productos.nombre, productos.precioventa, productos.preciocompra, productos.gastocomercializacion, 
                       productos.utilidad, productos.impuesto, productos.maximoprecio, productos.minimoprecio, productos.estado, productos.codigo, productos.cantidadapartado, productos.existencia',
                       'categorias.id','presentacions.nombre','personas.nombre'))
                       ->join('categorias','productos.idcategoria','=','categorias.id')
                       ->join('presentacions','productos.idpresentacion','=','presentacions.id')
                       ->join('personas','productos.idpersona','=','personas.id')
                       ->where('productos.estado','=','1')->get();
       return $producto;
       
   }
   public function store(Request $request)
    {
        try{
            $producto = new Producto();
            $producto->idcategoria=$request->idcategoria;
            $producto->idpresentacion=$request->idpresentacion;
            $producto->idpersona=$request->idpersona;
            $producto->nombre = $request->nombre;
            $producto->precioventa=$request->precioventa;
            $producto->preciocompra=$request->preciocompra;
            $producto->gastocomercializacion=$request->gastocomercializacion;
            $producto->utilidad=$request->utilidad;
            $producto->impuesto=$request->impuesto;
            $producto->maximoprecio=$request->maximoprecio;
            $producto->minimoprecio=$request->minimoprecio;
            $producto->estado = '1';
            $producto->codigo=$request->codigo;
            $producto->cantidadapartado=$request->cantidadapartado;
            $producto->existencia=$request->existencia;
            $producto->save();
            return 'Categoría agregada correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
        
    }
    public function update(Request $request)
    {
     
        $id=$request->id;
        $idcategoria=$request->idcategoria;
        $idpresentacion=$request->idpresentacion;
        $idpersona=$request->idpersona;
        $nombre=$request->nombre;
        $precioventa=$request->precioventa;
        $preciocompra=$request->preciocompra;
        $gastocomercializacion=$request->gastocomercializacion;
        $utilidad=$request->utilidad;
        $impuesto=$request->impuesto;
        $maximoprecio=$request->maximoprecio;
        $minimoprecio=$request->minimoprecio;
        $codigo=$request->codigo;
        $cantidadapartado=$request->cantidadapartado;
        $existencia=$request->existencia;

        try{
            $producto= Producto::findOrFail($id);
            $producto->idcategoria=$idcategoria;
            $producto->idpresentacion=$idpresentacion;
            $producto->idpersona=$idpersona;
            $producto->nombre = $nombre;
            $producto->precioventa=$precioventa;
            $producto->preciocompra=$preciocompra;
            $producto->gastocomercializacion=$gastocomercializacion;
            $producto->utilidad=$utilidad;
            $producto->impuesto=$impuesto;
            $producto->maximoprecio=$maximoprecio;
            $producto->minimoprecio=$minimoprecio;
            $producto->estado = '1';
            $producto->codigo=$codigo;
            $producto->cantidadapartado=$cantidadapartado;
            $producto->existencia=$existencia;
           
            $producto->save();
            return 'Producto modificado correctamente';
        }
        catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }

    }   
    public function activate(Request $request){
        $id=$request->id;
        try{
            $producto=Producto::findOrFail($id);
            $producto->estado='1';
            $producto->save();
            return 'Se ha activado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function desactivate(Request $request){
        $id=$request->id;
        try{
            $producto=Producto::findOrFail($id);
            $producto->estado='0';
            $producto->save();
            return 'Se ha desactivado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
}
