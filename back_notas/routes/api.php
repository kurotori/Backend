<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::get(
    '/usuarios',
    [RegisteredUserController::class, 'verTodos']
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
            [NotaController::class, 'verTodas']
        );

        Route::post(
            '/nota/nueva',
            [NotaController::class, 'nueva']
        );
    }
);
