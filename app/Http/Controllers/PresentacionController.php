<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Presentacion;
class PresentacionController extends Controller
{
        
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Presentacion::orderBy('created_at', 'desc')->get();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $presentacion=new Presentacion;
            $presentacion->nombre=$request->nombre;
            $presentacion->estado = '1';
            $presentacion->save();
            return 'Se ha agregado el rol correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /*$categoria = Categoria::findOrFail($request->Categoriaid);
        $categoria->nombre = $request->nombre;
        $categoria->estado = '1';
        $categoria->save();*/
        $id=$request->id;
        $nombre=$request->nombre;
        try{
            $presentacion= Presentacion::findOrFail($id);
            $presentacion->nombre=$nombre;
            $presentacion->estado = '1';
            $presentacion->save();
            return 'Se ha modificado la categoria correctamente';
        }
        catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }   
    public function drop(Presentacion $presentacion){
        try{
            $presentacion->delete();
            return 'Se ha eliminado la categoria correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
       
    }
    
    public function desactivar(Request $request)
    {
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->estado = '0';
        $presentacion->save();
    }
    public function activar(Request $request)
    {
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->estado = '1';
        $presentacion->save();
    }
}