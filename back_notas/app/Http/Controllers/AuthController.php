<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Controlador para manejar la autenticación mediante JWT
 */
class AuthController extends Controller
{
    /**
     * Permite registrar un usuario
     */
    public function registrar(Request $solicitud)
    {
        $solicitud->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $usuario = User::create([
            'name' => $solicitud->name,
            'email' => $solicitud->email,
            'password' => Hash::make($solicitud->password),
        ]);

        try {
            $token = JWTAuth::fromUser($usuario);
        } catch (JWTException $error) {
            return response()->json([
                'error' => 'No se pudo crear un token',
                'detalle' => $error
            ], 500);
        }


        return response()->json([
            'mensaje' => 'Usuario registrado exitosamente',
            'token' => $token,
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Permite iniciar sesión en el sistema utilizando JWTs
     */
    public function login(Request $solicitud)
    {
        $credentials = $solicitud->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales no válidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear un token'], 500);
        }

        //Establecer la cookie con el token en el cliente
        //$cookie = Cookie::make('token_jwt', $token, 60);
        //$response->withCookie(cookie('key', $value));

        return response()->json([
            'estado' => "OK",
            'destino' => 'notas'
            //'expires_in' => auth('api')-> factory()->getTTL() * 60,
        ])->withCookie(cookie('token_jwt', $token, 60));
    }

    /**
     * Permite cerrar una sesión
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ha ocurrido un error al intentar cerrar la sesión'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
