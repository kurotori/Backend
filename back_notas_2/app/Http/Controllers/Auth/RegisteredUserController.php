<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) //: RedirectResponse   BACKEND: se comenta para evitar un error por redireccionamiento
    {

        /**
         * BACKEND: Se deben tener en cuenta esta validación de datos para el registro de un usuario nuevo,
         *          ya que son los datos que deben estar contenidos en la solicitud.
         */
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
            /**
         * BACKEND: Que el campo 'password' sea requerido (propiedad 'required') y que deba ser
         *          confirmado (propiedad 'confirmed') implica que en la solicitud *debe incluírse*,
         *          además del campo 'password', un campo llamado 'password_confirmation'
         */


        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );

        event(new Registered($user));

        //Auth::login($user); BACKEND: Se comenta para evitar que el sistema inicie automáticamente sesión
        //                        recién creado

        return response()->json(
            [
                'estado' => 'OK',
                'mensaje' => 'Usuario registrado con éxito',
                'destino' => 'inicioSesion'
                //BACKEND: Este objeto de respuesta y sus atributos deben adaptarse a las necesidades del proyecto
            ],
            200
        );
        //BACKEND: Se comenta para evitar un error por redireccionamiento
        //return to_route('dashboard');
    }
}
