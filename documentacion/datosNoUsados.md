

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