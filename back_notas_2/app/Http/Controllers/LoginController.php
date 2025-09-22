<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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

            //Auth::login($usuario);
            //$sesion = $solicitud->sessi;//Auth::getSession();

            return response()->json(
                [
                    'estado' => 'OK',
                    'mensaje' => 'log in exitoso',
                    'usuario' => $usuario,
                    //'sesion' => $sesion->getID()
                ],
                200
            )->withCookie(cookie('token_jwt', '---', 60));
        } else {
        }
    }
}
