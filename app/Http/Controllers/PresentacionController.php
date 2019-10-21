<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Presentacion;
class PresentacionController extends Controller
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
        if(!$request->ajax())
            return redirect('/home');
        return Presentacion::orderBy('created_at', 'desc')
                            ->where('estado','=',true)
                            ->get();
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
            return 'Presentación agregada correctamente.';
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
            return 'Presentación modificada correctamente';
        }
        catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }   
    public function drop(Presentacion $presentacion){
        try{
            $presentacion->estado= 0;
            $presentacion->save();
            return 'Presentación eliminada correctamente';
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