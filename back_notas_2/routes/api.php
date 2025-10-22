<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/**
 * Permite recibir la solicitud para registrar un usuario nuevo en el sistema
 */
Route::post(
    '/usuarios/nuevo',
    [RegisteredUserController::class, 'store']
)->middleware('web');

/**
 * Permite recibir y responder a la solicitud de inicio de sesión
 */
Route::middleware('web')->post(
    'ingresar',
    [LoginController::class, 'autenticar']
);


/**
 * BACKEND: Grupo de rutas, en este caso, para funciones de usuario que requieren
 *          autenticación
 */
Route::prefix('usuarios')->middleware('auth:sanctum')->group(
    function(){
        Route::post('cerrarSesion', [LoginController::class,'cerrarSesion']);
    }
);
