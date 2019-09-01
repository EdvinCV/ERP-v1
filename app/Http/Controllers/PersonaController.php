<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        return Persona::orderBy('created_at', 'desc')->get();
       
    }
}
