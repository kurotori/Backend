<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return response()->json(
                [
                    'estado' => 'OK',
                    'mensaje' => 'log in exitoso',
                    'usuario' => $usuario,
                    //'sesion' => $sesion->getID()
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
}
