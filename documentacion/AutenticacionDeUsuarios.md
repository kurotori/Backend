# Autenticación de Usuarios en Laravel

1. [Configuración del Controlador](#1---configuración-del-controlador)
    1. [Iniciar una sesión](#iniciar-una-sesión)
2. [Configuración de la Ruta](#b---configuración-de-la-ruta)
3. [Proceso de Registro de Usuarios](#c---proceso-de-registro-de-usuarios)

## 1 - Configuración del Controlador

Como toda fucionalidad del backend, la debemos manejar mediante un **controlador**.

La instalación del _starter-kit_ de _Vue_ nos a dejado varios controladores que manejan muchas de las funcionalidades necesarias en el directorio [app/Http/Controllers/Auth][l1].

Lamentablemente, estas funcionalidades estan pensadas para trabajar con _vistas_ en un proyecto de _Laravel_ con frontend incluído, y no podemos usarlas directamente si queremos usar nuestro proyecto _solo_ como backend .

Pero podemos tomarlos como referencia para nuestras propias funciones.

Crearemos un controlador desde la consola con el comando

```sh
    php artisan make:controller
```

En este ejemplo, creamos un controlador llamado **LoginController** ([ver archivo][l2]). En este controlador vamos a definir las acciones relacionadas con el inicio de sesión, específicamente:

- Autenticar un usuario e iniciar una sesión
- Cerrar una sesión

### Iniciar una sesión

Para iniciar una sesión, creamos una función pública en nuestro controlador, llamada `autenticar()`, que recibe un objeto de clase `Request` llamado `$solicitud` que contendrá todos los datos de la solicitud entrante recibida por el backend.

> **Nota:** _La clase `Request` contiene las funcionalidades necesarias para manejar solicitudes entrantes al servidor en general, y la usaremos en prácticamente todas las funcionalidades del backend._

```php
    public function autenticar(Request $solicitud)
    {

    }
```

Esta función, en primer lugar, **validará los datos ingresados** en la solicitud mediante el método `validate()` de la clase `Request`. Este método puede llamarse diréctamente desde el objeto `$solicitud`, ya que, como se vió más arriba, pertenece a la clase `Request`.

Este método me permite indicar **qué datos** y con **qué características** se deben admitir para continuar el proceso. De no superarse esta validación, el proceso se detiene y se genera un mensaje error automáticamente.

Si se supera la validación de datos, estos se almacenan en un objeto que llamamos `$credenciales`, que usaremos para el siguiente paso del proceso.

```php
    $credenciales = $solicitud->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
```

Las credenciales se utilizan para autenticar al usuario e intentar un inicio de sesión en el sistema. Esto se realiza mediante el método `attempt()` de la clase `Auth`.

Este método retorna `true`, si la autenticación es exitosa. O `False`, si no lo es. Por lo que podemos utilizar el resultado del mismo en una estructura `if-else` para generar las respuestas del sistema:

```php
    if ( Auth::attempt($credenciales) ) {

    }
    else{

    }
```

Si la autenticación es exitosa, iniciamos el proceso de vinculación de la sesión al usuario, aprovechando funcionalidades del objeto `$solicitud`:

1. Solicitamos al sistema que inicie una sesión vinculada a la solicitud (método `session()->start()`):

    ```php
        if ( Auth::attempt($credenciales) ) {
            $solicitud->session()->start();
        }    
    ```

2. Regeneramos la `id` de la sesión, para minimizar la posibilidad de [**ataques por fijación de sesiones**][l3] (método `session()->regenerate()`):

    ```php
        if ( Auth::attempt($credenciales) ) {
            $solicitud->session()->start();
            $solicitud->session()->regenerate();
        }
    ```

3. Extraer los datos del usuario autenticado para transmitirlos en la respuesta:

    ```php
        if ( Auth::attempt($credenciales) ) {
            $solicitud->session()->start();
            $solicitud->session()->regenerate();
            
            $usuario = $solicitud->user();
        }
    ```

4. Se genera y envía una respuesta del servidor con los datos necesarios para confirmar el inicio de sesión exitoso en el frontend (los datos del usuario, por ejemplo):

    ```php
        if ( Auth::attempt($credenciales) ) {
            $solicitud->session()->start();
            $solicitud->session()->regenerate();
            
            $usuario = $solicitud->user();

            return response()->json(
                [
                    'estado' => 'OK',
                    'mensaje' => 'Inicio de Sesión exitoso',
                    'usuario' => $usuario,
                    'destino' => 'inicio'
                ],
                200
            );
        }
    ```

5. Si la autenticación falla, se genera una respuesta de error (de acuerdo al estándar, el código de error a enviar sería [401][l4]):

    ```php
        else {
            return response()->json(
                [
                    'estado' => 'ERROR',
                    'mensaje' => 'Error en el nombre de usuario o la contraseña',
                ],
                401
            );
        }
    ```

***

### Cerrar una sesión

Para cerrar una sesión iniciada crearemos una función pública semejante a la anterior, que recibirá como parámetro un objeto `$solicitud` de clase `Request`.

```php
    public function cerrarSesion(Request $solicitud){

    }
```

El proceso de cierre de sesión es el siguiente:

1. Se realiza una llamada a al `facade` **Auth** para ejecutar el método `logout()` y desvincular la sesión del usuario identificado en la sesión.

    ```php
        Auth::logout();
    ```

> **Nota:** _Un `facade`, o "fachada", es una estructura de Laravel que permite acceder a recursos de la sesión, la base de datos, etc. sin tener que realizar una inyección de dependencias (como cuando dependemos de un objeto de la clase `Request` para obtener datos de la solicitud). Son útiles para simplificar el código, pero se debe tener cuidado al usar `facades` para evitar que nuestras funciones presenten abuso de alcance._

2. 

[l1]: ../back_notas_2/app/Http/Controllers/Auth/
[l2]: ../back_notas_2/app/Http/Controllers/LoginController.php
[l3]: https://owasp.org/www-community/attacks/Session_fixation
[l4]: https://developer.mozilla.org/es/docs/Web/HTTP/Reference/Status/401
