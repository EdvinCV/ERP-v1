<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function index(){
        $usuarios = DB::table('users')
                        ->select('users.id', 'users.name', 'users.email', 'rols.nombreRol','users.estado')
                        ->join('rols', 'rols.id', '=', 'users.rolId')
                        ->get();
        return $usuarios;
      
    }

    public function inicio(){
        $usuarios = DB::table('users')
            ->select(DB::raw('users.id' ))
            ->whereRaw('DATE_FORMAT(users.last_login,"%y-%m-%d") < curdate()')
            ->where('id','=',Auth::user()->id)
            ->groupBy('users.id')           
            ->get()
            ->count();
        return $usuarios;
    }

    public function listarRolCompras(){
        $users = DB::table('users')
        ->select('users.id', 'users.name', 'users.email', 'rols.nombreRol','users.estado')
        ->join('rols', 'rols.id', '=', 'users.rolId')
        ->where('rols.nombreRol', '=', 'Compras')
        ->get();
        
        return $users;
    }

    public function store(Request $request){
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->pass);
            $user->estado = 1;
            $user->rolId = $request->rol;
            $user->save();
            return 'Usuario creado correctamente';
        } catch (\Exception $e) {
            if (User::where('email', '=', $request->email)->count() > 0){
                $response['error'] = 'No se ha ingresado. Este correo ya existe.';
                return response()->json($response, 500);
            }else{
                $response['error'] = $e->getMessage();
                return response()->json($response, 500);
            }
            
        }

    }

    public function drop($id){
        try{
            $user = User::find($id);
            $user->estado = 0;
            $user->save();
            return 'Usuario desactivado correctamente';
        }catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function update(Request $request){
        try {
            $user = User::findOrFail(Auth::id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->estado = $request->switch1;
            $user->save();
            return 'Usuario actualizado correctamente';
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
  

    public function updateProfile(Request $request)
    {
      
       
        $user = User::findOrFail(Auth::id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->estado = '1';
  
            $user->save();
            return redirect()->back();

       
      
    }




public function updatePassword(Request $request)
    {
       

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::findOrFail(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
               
                Auth::logout();
                return redirect()->back();
            } else {
               
                return redirect()->back();
            }
        } else {
           
            return redirect()->back();
        }
    }
  
    
}
