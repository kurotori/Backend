<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post(
    '/usuario/nuevo',
    [RegisteredUserController::class, 'store']
)->middleware('web');

Route::middleware('web')->post(
    'ingresar',
    [LoginController::class, 'autenticar']
    //[AuthController::class, 'login']
);
