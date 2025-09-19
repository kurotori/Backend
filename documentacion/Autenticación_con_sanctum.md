# Autenticación con Sanctum

La autenticación con Laravel se logra mediante **tokens** que son expedidos por la API

1. **Asegurarse** de que el archivo `config/sanctum.php`:
   - Contiene el atributo `stateful`, y que este incluye **_de forma explícita_** el dominio del frontend (usar). ([ver en archivo](../back_notas_2/config/sanctum.php))
    En general, si estamos trabajando con _Vue_, el atributo `stateful` será semejante a lo siguiente:

    ~~~php
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,127.0.0.1:5173,localhost:5173::1',
        Sanctum::currentApplicationUrlWithPort(),
    ))),
    ~~~

    - Contiene el el atributo `support_credentials`, y que su valor es `true`

2. Agregar el atributo **HasApiTokens** al modelo de usuario (**_/app/Http/Models/User.php_**) ([ver en el archivo](../back_notas_2/app/Models/User.php)) para facilitar el uso de tokens de `sanctum` con el mismo.

3. **IMPORTANTE:** Hace falta **configurar adecuadamente** la instancia de **Axios** en el frontend para que solicite la cookie CSRF

4. **Configurar:**

   - En el archivo `bootstrap/app.php`, el middleware `statefulApi` ([ver en el archivo](../back_notas_2/bootstrap/app.php))
   

5. Configurar en config/session.php:
   'secure', agregar parámetro true

// - - - Atención: Información en Revisión, no considerar - - -

3. Instalar composer require tymon/jwt-auth
4. php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
5. php artisan jwt:secret
6. Agregar los **guards** adecuados en **config/auth.php** (ver en archivo)
7. Modificar el modelo de usuario **/app/Http/Models/User.php** para que maneje JWT (ver en archivo)
8. Crear un controlador llamado **AuthController** (con el comando **_php artisan make:controller AuthController_**)
9. Agregar en **AuthController** las funciones de registro, login y logout (ver en archivo)
10. Crear un **middleware** para gestionar el acceso a páginas protegidas (con el comando **_php artisan make:middleware JwtMiddleware_**) y agregarle las funciones de gestión correspondientes (ver en archivo, ubicado en **app/Http/Middleware/JwtMiddleware**)
11. Registrar el middleware en el archivo **bootstrap/app.php** (ver en archivo)
12. Crear un grupo de rutas en **routes/api.php** las cuales estarán protegidas por el middleware que creamos (ver en archivo)

_Adaptado del artículo: ["How to Implement JWT Authentication in Laravel 12"](https://medium.com/@aliboutaine/how-to-implement-jwt-authentication-in-laravel-12-1e2ae878d5dc), por Ali Boutaine_
