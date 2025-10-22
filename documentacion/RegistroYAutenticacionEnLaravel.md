# Registro de Usuarios en Laravel

1. [Registro de Usuarios](#1---registro-de-usuarios)
    1. [Configuración del Controlador](#a---configuración-del-controlador)
    2. [Configuración de la Ruta](#b---configuración-de-la-ruta)
    3. [Proceso de Registro de Usuarios](#c---proceso-de-registro-de-usuarios)

***

## 1 - Registro de Usuarios

### A - Configuración del Controlador

Si configuramos el proyecto de Laravel como se mencionó [al comienzo de esta documentación][l1], nuestro proyecto debería contar con un directorio llamado `Auth` en `app/Http/Controllers` ([ver en el proyecto][l2]).
Este directorio contiene controladores que nos serán útiles para el registro de usuarios en nuestro sistema, particularmente [`RegisteredUserController.php`][l3].

En este controlador encontraremos la función `store`, que usaremos para registrar un usuario nuevo, con algunas modificaciones, ya que la función original redirige a una página interna e inicia automáticamente la sesión del nuevo usuario (asume que estamos desarrollando un proyecto que incluye frontend y backend en el mismo paquete). Por este motivo, comentaremos las siguientes líneas de código:

1. En la declaración de la función `store`, comentamos el tipo de datos de retorno `RedirectResponse`:

   ```php
       public function store(Request $request) //:RedirectResponse
   ```

2. En el cuerpo de la función `store`:

   - Si deseamos deshabilitar el inicio de sesión automático del nuevo usuario, comentamos la siguiente línea:

     ```php
            //Auth::login($user);
     ```

   - Comentamos la línea `return to_route` que se encuentra al final:

     ```php
             //return to_route('dashboard');
     ```

3. Finalmente, le agregaremos a la función un retorno con un objeto `response` que le indique al frontend el resultado de la operación y que, en caso de éxito, se redirija hacia la página de inicio de sesión mediante una variable adecuada.

_[Volver al Comienzo][inicio]_
***

### B - Configuración de la Ruta

En el archivo `routes/api.php` ([ver en el archivo][l4]) declararemos una ruta de tipo `post` para recibir los datos de registro de usuarios, y la vinculamos a la función adecuada en el controlador (en este caso, la función `store`).

```php
    Route::post(
        '/usuarios/nuevo',
        [RegisteredUserController::class, 'store']
    );
```

En Laravel, el proceso de inicio de sesión se basa en el uso de `cookies` seguras (del tipo `http-only`) que contienen `tokens`: secuencias alfanuméricas que permiten identificar la sesión ante el backend.

> **Nota:** Las `cookies` son datos que el backend envía al navegador para almacenar **información de estado** (). Cuando el frontend realiza una solicitud al backend, las cookies correspondientes a ese backend son enviadas junto con la solicitud. Se puede ver información más detallada al respecto en [el sitio de MDN][l5].

Laravel utiliza dos `cookies` conteniendo `tokens` específicos:

- `XSRF-TOKEN`: Contiene información que permite **autenticar la conexión** ante el backend. Una conexión no autenticada será rechazada por el backend con un error 419.
- `laravel_session`: Contiene la id de la **sesión de uso** iniciada al conectarse al backend. Se debe diferenciar de una **sesión de usuario**, ya que se trata de una _sesión anónima_ (no está vinculada a ningún usuario)

El proceso es, aproximadamente, el siguiente:

![Diagrama de manejo de cookies de Laravel][l6]

Para que este intercambio sea posible, el backend debe tener la ruta bajo una **"guardia"**: un `middleware` que se encarga de monitorear y efectivizar este proceso. En este caso, el `middleware` que utilizaremos es llamado 'web'.

> **Nota:** un `middleware` es una capa de software intermedia que facilita la comunicación entre distintos componentes de la aplicación al encapsular los procesos necesarios.

Para asegurarnos de que nuestra ruta este bajo este `middleware` lo que debemos hacer es, simplemente, agregar esa información a la declaración de la ruta de la siguiente manera:

```php
    Route::middleware('web')->post(
        '/usuarios/nuevo',
        [RegisteredUserController::class, 'store']
    );
```

o, alternativamente:

```php
    Route::post(
        '/usuarios/nuevo',
        [RegisteredUserController::class, 'store']
    )->middleware('web');
```

Esto coloca a la ruta bajo la guardia del middleware `web`, para que tenga que usar las `cookies` de _Laravel_ que mencionamos. Ahora, todas las solicitudes de creación de usuarios deberán recibir, previamente, estas `cookies` para que sean aceptadas por el backend.

Todas las `cookies` de _Laravel_ se configuran como `http-only`, esto significa que no pueden accederse desde el _DOM_ ni desde _JavaScript_, lo cual añade seguridad al sistema, ya que esto limita la posibilidad de que estas `cookies` sean capturadas mediante un ataque _XSS_.

> **Nota:** Se puede conocer más sobre el rol de las `cookies` en [este documento de MDN][l7]
> **Nota:** _Todas las solicitudes_ al backend, en una ruta protegida por una guardia, deben solicitar **primero**, mediante `get`, una `cookie` al servidor en la ruta **/sanctum/csrf-cookie**, para luego realizar la solicitud deseada.

### C - Proceso de Registro de Usuarios

Para efectivizar el registro de usuarios, debemos enviar una solicitud, mediante `post`, a la ruta que establecimos (que en este ejemplo sería **/api/usuarios/nuevo**).

El proceso completo de solicitudes es el siguiente:

1. Solicitar `cookies` de sesión al `sanctum` mediante una petición `get` a **/sanctum/csrf-cookie**

1. Enviar una solicitud `post` con los datos del usuario, que, según el método `store()` del controlador **RegisteredUserController**, estos datos deberían ser:
    - _name_ (nombre)
    - _email_ (correo electrónico)
    - _password_, y _password_confirmation_ (contraseña y confirmación de la contraseña)

    [ver notas en el archivo][l3]

    > **Nota:** _Estos datos pueden modificarse de acuerdo a las necesidades de cada proyecto, modificando el modelo de usuario y las migraciones correspondientes_

    Estos datos se reciben mediante un objeto de clase `Request` llamado `$request` que se declara como parámetro de entrada del método `store()`.

    ```php
        public function store(Request $request)
        {

        }
    ```

    Estos datos deben pasar por un proceso de **validación** para evitar el ingreso de datos maliciosos, y que el servidor del backend malgaste potencia de cómputo en una solicitud mal formada. Esta validación se realiza mediante el método `validate()`, que se encuentra en la clase `Request`, por lo que lo podemos llamar diréctamente del objeto `$request` y pasarle los parámetros de validación mediante un array:

    ```php
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    ```

    Si los datos son correctos, se crea un registro de usuario mediante la función `create()` del modelo **User**, al cual le pasamos un array incluyendo los datos necesarios desde el objeto `$request`:

    ```php
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
    ```

1. Almacenamos el detalle del usuario creado en el objeto `$user`, y se genera un retorno con respuesta en _JSON_ para interpretarse en el frontend ([ver notas en el archivo][l3]).

    ```php
        return response()->json(
            [
                'estado' => 'OK',
                'mensaje' => 'Usuario registrado con éxito',
                'destino' => 'inicioSesion'
            ],
            200
        );
    ```

1. Si la validación no se supera, o por algún otro error (el usuario ya existe, etc.), se genera una respuesta indicando el error (por lo general de [código 422][l8])

_[Volver al Comienzo][inicio]_
***

## Siguiente: [Autenticación de Usuarios][siguiente]

[inicio]: #registro-de-usuarios-en-laravel
[l1]: README.md
[l2]: ../back_notas_2/app/Http/Controllers/Auth/
[l3]: ../back_notas_2/app/Http/Controllers/Auth/RegisteredUserController.php
[l4]: ../back_notas_2/routes/api.php
[l5]: https://developer.mozilla.org/es/docs/Web/HTTP/Guides/Cookies
[l6]: out/diagramaCookiesLaravel/DiagramaCookiesLaravel.png
[l7]: https://developer.mozilla.org/es/docs/Web/HTTP/Guides/Cookies
[l8]: https://developer.mozilla.org/es/docs/Web/HTTP/Reference/Status#errores_de_servidor
[siguiente]: AutenticacionDeUsuarios.md
