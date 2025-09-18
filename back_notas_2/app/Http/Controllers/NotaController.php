<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    //
    public function verTodas()
    {
        //$notas = Nota::all();
        $notas = DB::table('notas')
            ->select('id', 'titulo', 'texto', 'created_at as fecha')
            ->get();
        return response()->json(
            [
                'estado' => 'OK',
                'notas' => $notas
            ]
        );
    }

    /**
     * Permite registrar una nueva nota en el sistema
     */
    public function nueva(Request $solicitud)
    {
        $validacion = $solicitud->validate(
            [
                'titulo' => 'required|string|max:50',
                'texto' => 'required|string|max:250'
            ]
        );

        $nota = Nota::create($validacion);
        return response()->json([
            'estado' => 'OK',
            'mensaje' => 'Nota creada con éxito'
        ]);
    }
}
