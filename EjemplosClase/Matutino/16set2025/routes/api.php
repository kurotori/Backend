<?php

use App\Http\Controllers\BichoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get(
    '/prueba',
    function () {
        return response()->json([
            'estado' => 'OK',
            'mensaje' => 'Si podés leer esto, estas muy cerca'
        ], 200);
    }
);

Route::get(
    '/bichos',
    [BichoController::class, 'verTodos']
);

Route::post(
    '/bicho/nuevo',
    [BichoController::class, 'nuevo']
);

Route::post(
    'ingresar',
    function () {
        return response()->json([
            'estado' => 'OK',
            'mensaje' => 'Si podés leer esto, estas muy cerca'
        ], 200);
    }
);
