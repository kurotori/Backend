<?php

namespace App\Http\Controllers;

use App\Models\Bicho;
use Illuminate\Http\Request;

class BichoController extends Controller
{
    /**
     * Permite obtener el listado completo de Bichos de la Base de datos
     */
    public function verTodos()
    {
        $bichos = Bicho::all();

        return response()->json(
            [
                'estado' => 'OK',
                'mensaje' => 'Listado de Bichos',
                'bichos' => $bichos
            ],
            200
        );
    }

    /**
     * Permite agregar un bicho a la base de datos
     */
    public function nuevo(Request $solicitud)
    {
        $bicho = $solicitud->validate([
            'nombre' => 'required|string|max:50|min:2',
            'especie' => 'required|string|max:50|min:5'
        ]);

        $bichoCreado = Bicho::create($bicho);

        return response()->json(
            [
                'estado' => 'OK',
                'mensaje' => 'Bicho Registrado',
                'bicho' => $bichoCreado
            ],
            200
        );
    }
}
