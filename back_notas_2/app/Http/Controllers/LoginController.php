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
            //$sesion = $solicitud->session();

            return response()->json(
                [
                    'estado' => 'OK',
                    'mensaje' => 'Inicio de Sesión exitoso',
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
                401
            );
        }
    }


    public function cerrarSesion(Request $solicitud){
        Auth::logout();
        $solicitud->session()->flush();
        $solicitud->session()->invalidate();
        $solicitud->session()->regenerateToken();

        return response()->json(
            [
                'estado'=>'OK',
                'mensaje'=>'Sesión cerrada con éxito',
                'destino'=>'login'
            ],
            200
        );
    }
}
