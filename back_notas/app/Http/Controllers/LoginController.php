<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    //
    public function autenticar(Request $solicitud)
    {
        $credenciales = $solicitud->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        if (Auth::attempt($credenciales)) {
            //$solicitud->session()->regenerate();
            $usuario = Auth::user();
            session()->start();
            session(['clave' => 'cosacosa']);
            $valor = session()->get('clave');
            /*
            try {
                if (!$token = JWTAuth::attempt($credenciales)) {
                    return response()->json(['error' => 'Credenciales no válidas'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'No se pudo crear un token'], 500);
            } */

            return response()->json(
                [
                    'estado' => 'OK',
                    'mensaje' => 'log in exitoso',
                    'usuario' => $usuario,
                    'valor' => $valor
                ],
                200
            )->withCookie(cookie('token_jwt', '---', 60));
        }
    }
}
