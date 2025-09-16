<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotaController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get(
    '/cookie',
    function (Request $solicitud) {
        print($cookie = $solicitud->cookie('token_jwt'));
    }
);


Route::get(
    '/usuarios',
    [RegisteredUserController::class, 'verTodos']
);

Route::get(
    '/usuario/{id}/notas',
    function ($id) {
        $usuario = User::find($id);
        return response()->json(
            [
                'usuario' => $usuario,
                'notas' => $usuario->notas()
            ]
        );
    }
);


Route::post(
    '/usuario/nuevo',
    [RegisteredUserController::class, 'store']
);

Route::post(
    'ingresar',
    [AuthController::class, 'login']
);

//Grupo Agregado para manejo con JWT
Route::middleware('jwt')->group(
    function () {
        //Cerrar sesión
        Route::post('/logout', [AuthController::class, 'logout']);

        //Ver notas del usuario
        Route::get(
            '/notas',
            //[NotaController::class, 'verTodas']
            function (Request $solicitud) {
                $cookie = $solicitud->cookie('token_jwt');
                //return $solicitud->user()->notas();
                return response()->json([
                    'jwt_token' => $cookie
                ], 200);
            }
        );

        Route::post(
            '/nota/nueva',
            [NotaController::class, 'nueva']
        );
    }
);
