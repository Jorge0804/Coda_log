<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class UsuarioController extends Controller
{
	public function __construct()
	{
		$this->middleware('CheckLogin')->only('mostrarformregistro');
	}

    function mostrarformlogin()
    {
    	if(session('usuario'))
    	{
    		return redirect('home');
    	}
    	return view('usuario.login');
    }

    function mostrarformregistro()
    {
    	return view('usuario.registro');
    }

    function registrar(Request $r)
    {
    	if($r->pass == $r->pass2)
    	{
    		$usuario = new Usuario();
    		$usuario->nombre = $r->nombre;
    		$usuario->paterno = $r->paterno;
    		$usuario->materno = $r->materno;
    		$usuario->telefono = $r->telefono;
    		$usuario->user_name = $r->correo;
    		$usuario->pass = Crypt::encrypt($r->pass);
    		$usuario->save();

            $usuario = Usuario::where('user_name', '=', $r->nombre)->first();
            session(['usuario' => $usuario]);
            return redirect()->route('inicio');
    	}
    	return back()->with("mensaje","Las contraseñas no coinciden")
            ->withInput();
    }

    function IniciarSesion(Request $r)
    {
    	foreach (Usuario::all() as $usuario) {
    		if($r->user == $usuario->user_name && $r->pass == Crypt::decrypt($usuario->pass))
    		{
    			$usuario = Usuario::where('user_name', '=', $r->user)->first();
    			session(['usuario' => $usuario]);
    			return redirect()->route('inicio');
    		}
    		return back()->with("mensaje","Usuario y/o contraseña incorrectos")
		    ->withInput();
    	}
    }

    function CerrarSesion()
    {
    	Session()->flush();
    	return redirect('/');
    }
}
