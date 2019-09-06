<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Rol;

class UsuarioController extends Controller
{
    function mostrarformlogin()
    {
        if (count(Usuario::all())) {
            return view('usuario.login');
        }
        return redirect('/FormRegistro');  	
    }

    function mostrarformregistro()
    {
        if (count(Usuario::all())) {
            if (session('usuario')) {
                if (session('usuario')->rol != 3) {
                    return redirect('/FormCotizar');
                }
                return redirect('/CotiRegistradas');
            }
            return redirect('/');
        }
    	return view('usuario.registro');
    }

    function registrar(Request $res)
    {
        parse_str($res->datos, $r);

        if (!count(Usuario::where('user_name', '=', $r['correo'])->get())) 
        {
            if($r['pass'] == $r['pass2'])
            {
                $usuario = new Usuario();
                $usuario->nombre = $r['nombre'];
                $usuario->user_name = $r['correo'];
                $usuario->rol = $r['rol'];
                $usuario->pass = Crypt::encrypt($r['pass']);
                $usuario->save();

                if (!Session::has('usuario')) {
                    $usuario = Usuario::where('user_name', '=', $r->nombre)->first();
                    session(['usuario' => $usuario]);
                    return redirect()->route('inicio');
                }
                return ['mensaje' => 'Registrado', 'estatus' => 'bien'];
            }
            if (!Session::has('usuario')) {
                return back()->with("mensaje","Las contraseñas no coinciden")
                ->withInput();
            }
            return ['mensaje' => 'Las contraseñas no coinciden', 'estatus' => 'mal'];
        }
        return ['mensaje' => 'Este usuario ya existe', 'estatus' => 'mal'];
    }

    function RegPrimerUsuario(Request $r)
    {
        if($r['pass'] == $r['pass2'])
        {
            $usuario = new Usuario();
            $usuario->nombre = $r['nombre'];
            $usuario->user_name = $r['correo'];
            $usuario->pass = Crypt::encrypt($r['pass']);
            $usuario->save();

            $usuario = Usuario::where('user_name', '=', $r->nombre)->first();
            session(['usuario' => $usuario]);
            return redirect()->route('inicio');
        }
            return back()->with("mensaje","Las contraseñas no coinciden");
    }

    function IniciarSesion(Request $r)
    {
        $flag = false;
    	foreach (Usuario::all() as $usuario) {
    		if($r->user == $usuario->user_name && $r->pass == Crypt::decrypt($usuario->pass))
    		{
    			$sesionUsuario = Usuario::where('user_name', '=', $r->user)->first();
                if ($sesionUsuario->estado == 1) {
                    $flag = true;
                }
    		}
    	}
        if ($flag) {
            session(['usuario' => $sesionUsuario]);
            if (Session::get('usuario')->rol != 3) {
                return redirect()->route('inicio');
            }
            return redirect()->route('registradas');
        }
        return back()->with("mensaje","Usuario y/o contraseña incorrectos")
            ->withInput();
    }

    function CerrarSesion()
    {
    	Session()->flush();
    	return redirect('/');
    }

    function FormGestionar()
    {
        if (count(Usuario::all())) {
            if (session('usuario')) {
                if (session('usuario')->rol == 2) {
                    return redirect('/FormCotizar');
                }
                elseif (session('usuario')->rol == 3) {
                    return redirect('/CotiRegistradas');
                }
                $usuarios = Usuario::with('rol')->get();
                $roles = Rol::all();
                foreach ($usuarios as $usuario) {
                    $usuario['rol'] = Rol::find($usuario->rol);
                }
                return view('usuario.usuarios', compact('usuarios'), compact('roles'));
            }
            return redirect('/');
        }
        return redirect('/FormRegistro');
    }

    function EliminarUsuario(Request $id)
    {
        $user = Usuario::find($id['info']);
        $user->estado = 0;
        $user->save();
        return ['mensaje' => 'Usuario eliminado'];
    }
}
