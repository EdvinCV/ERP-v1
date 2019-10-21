<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Historialcalidad;
use App\Producto;
class HistorialcalidadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 
    public function index(Request $request){
        if(!$request->ajax())
            return redirect('/home');
            $historialcalidad = DB::table('historialcalidads')
            ->select(DB::raw('historialcalidads.id, productos.nombre as Producto,historialcalidads.calificacion,
            DATE_FORMAT(historialcalidads.fecha,"%d-%m-%Y") as fecha, descripcion, CONCAT(productos.nombre, " - " ,presentacions.nombre,  " - ",proveedors.nombreProveedor) as mostrar'))
            ->join('productos','historialcalidads.idproducto','=','productos.id')
            ->join('presentacions','productos.idpresentacion','=','presentacions.id')
            ->join('personas','productos.idpersona','=','personas.id')
            ->join('proveedors', 'proveedors.idpersona', '=', 'personas.id')
            ->get();
        return $historialcalidad;
    }
    public function store(Request $request)
    {
        try{
            $historialcalidad = new Historialcalidad();
            $historialcalidad->idproducto=$request->idproducto;
            $historialcalidad->calificacion = $request->calificacion;
            $historialcalidad->fecha = $request->fecha;
            $historialcalidad->descripcion = $request->descripcion;
            $historialcalidad->save();
            return 'Historial de calidad agregado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function update(Request $request)
    {
        $id=$request->id;
        $idproducto=$request->idproducto;
        $calificacion=$request->calificacion;
        $fecha=$request->fecha;
        $descripcion=$request->descripcion;
        try{
            $historialcalidad= Historialcalidad::findOrFail($id);
            $id=$request->id;
            $historialcalidad->idproducto=$request->idproducto;
            $historialcalidad->calificacion = $request->calificacion;
            $historialcalidad->fecha = $request->fecha;
            $historialcalidad->descripcion = $request->descripcion;
            $historialcalidad->save();
            return 'Historial de calidad modificado correctamente';
        
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function drop(Historialcalidad $historialcalidad){
        try{
            $historialcalidad->delete();
            return 'Historial de calidad eliminado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
       
    }
}