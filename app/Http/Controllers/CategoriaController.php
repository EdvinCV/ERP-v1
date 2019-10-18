<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Categoria;

class CategoriaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return Categoria::orderBy('created_at', 'desc')->get();
        $categoria = DB::table('categorias')
            ->select(DB::raw('categorias.id, categorias.nombre'))
            ->where('categorias.estado','=','1')->get();
        return $categoria;
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
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->estado = '1';
            $categoria->save();
            return 'Categoría agregada correctamente';
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
            $categoria= Categoria::findOrFail($id);
            $categoria->nombre=$nombre;
            $categoria->estado = '1';
            $categoria->save();
            return 'Categoría modificada correctamente';
        }
        catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }

    }   
    public function drop(Categoria $categoria){
        try{
            $categoria->estado = 0;
            $categoria->save();
            return 'Categoría eliminada correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
       
    }
    
    public function desactivate(Request $request){
        $id=$request->id;
        try{
            $categoria=Categoria::findOrFail($id);
            $categoria->estado='0';
            $categoria->save();
            return 'Se ha desactivado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }
    public function activar(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->estado = '1';
        $categoria->save();
    }

}
