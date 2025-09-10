<?php

use App\Http\Controllers\NotaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get(
    '/notas',
    [NotaController::class, 'verTodas']
);

Route::post(
    '/nota/nueva',
    [NotaController::class, 'nueva']
);
