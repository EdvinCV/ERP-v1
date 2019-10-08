<?php

namespace App\Http\Controllers;
use App\loginActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginActivityController extends Controller
{
    public function inicio(){
        $usuarios = DB::table('login_activities')
            ->select(DB::raw('DATE_FORMAT(login_activities.created_at,"%Y-%m-%d") as Fecha' ))
            ->where('user_id','=','3')
            ->orderby('id','Desc')
            ->limit(2)
            ->get();
        return $usuarios;
    }
}
