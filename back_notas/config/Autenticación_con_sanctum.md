# Autenticación con Sanctum

La autenticación con Laravel se logra mediante **tokens** que son expedidos por la API

1. Asegurarse de que el archivo **config/sanctum.php** contiene el tributo **stateful**, y que este incluye ***de forma explícita*** el dominio del frontend.
2. Agregar **HasApiTokens** al modelo de usuario (***/app/Http/Models/User.php***)
3. Instalar composer require tymon/jwt-auth
4. php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
5. php artisan jwt:secret
6. Agregar los **guards** adecuados en **config/auth.php** (ver en archivo)
7. Modificar el modelo de usuario **/app/Http/Models/User.php** para que maneje JWT (ver en archivo) 
8. Crear un controlador llamado **AuthController** (con el comando ***php artisan make:controller AuthController***)
9. Agregar en **AuthController** las funciones de registro, login y logout (ver en archivo)
10. Crear un **middleware** para gestionar el acceso a páginas protegidas (con el comando ***php artisan make:middleware JwtMiddleware***) y agregarle las funciones de gestión correspondientes (ver en archivo, ubicado en **app/Http/Middleware/JwtMiddleware**)
11. Registrar el middleware en el archivo **bootstrap/app.php** (ver en archivo)
12. Crear un grupo de rutas en **routes/api.php** las cuales estarán protegidas por el middleware que creamos (ver en archivo)


*Adaptado del artículo: ["How to Implement JWT Authentication in Laravel 12"](https://medium.com/@aliboutaine/how-to-implement-jwt-authentication-in-laravel-12-1e2ae878d5dc), por Ali Boutaine*
