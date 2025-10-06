<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;

class LoginController extends Controller
{
    /**
     * Permite autenticar a un usuario
     */
    public function autenticar(Request $solicitud)
    {

        $credenciales = $solicitud->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        if (Auth::attempt($credenciales)) {
            $solicitud->session()->start();
            $solicitud->session()->regenerate();
            $usuario = $solicitud->user();
            $sesion = $solicitud->session();

            return response()->json(
                [
                    'estado' => 'OK',
                    'mensaje' => 'log in exitoso',
                    'usuario' => $usuario,
                    'destino' => 'inicio'
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'estado' => 'ERROR',
                    'mensaje' => 'Error en el nombre de usuario o la contraseña',
                ],
                403
            );
        }
    }


    public function cerrarSesion(Request $solicitud){
        try {
            Session::flush();
            Auth::logout();
            return response()->json(
                [
                    'estado'=>'OK',
                    'mensaje'=>'Sesión cerrada con éxito'
                ],
                200
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
