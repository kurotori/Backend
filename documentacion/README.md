# Documentación: Desarrollo de un Backend para un frontend _Vue_

1. **Instalar** los requerimientos para el desarrollo de Laravel mediante [el comando indicado en la documentación oficial](https://laravel.com/docs/12.x/installation). **_Se debe cerrar y volver a abrir la consola para el siguiente paso._**
2. **Generar** el proyecto con el comando `laravel new`, con las siguientes opciones:
   - Nombre del proyecto
   - Starter kit: **Vue**
   - Autenticación: **Laravel built-in**
   - Testing framework: **PHPUnit**
     *Nota:*No es realmente necesaria la ejecución del comando `npm install` al finalizar
3. **Configurar el proyecto como Backend**:
   - Agregar librerías y acceso al archivos de rutas de API con el comando `php artisan install:api`
4. **Añadir** el atributo `HasApiTokens` al modelo de usuario ([ver archivo](../app/Models/User.php))
5. **Definir** las estructuras de la base de datos mediante migraciones, y crear los modelos correspondientes. Por conveniencia, se recomienda crear los modelos e indicar, _en el mismo comando_, que se creen las migraciones correspondientes.
   Por ejemplo, para un modelo llamado `Cosa`, el comando sería: `php artisan make:model Cosa -m`
   De lo contrario, es posible crear migraciones de forma individual con el comando `php artisan make:migration`
   Y los modelos mediante el comando `php artisan make:model`
   Luego de definir las migraciones, se debe ejecutar el comando `php artisan migrate` para que se apliquen sus cambios a la base de datos del sistema. (Hay más información sobre el manejo de bases de datos [en este documento](BasesDeDatosEnLaravel.md))
6. **Configurar** las características de los modelos (campos rellenables, campos ocultos, relaciones entre modelos, etc.)
7. **Crear y configurar los controladores** definiendo las funciones que hagan falta. Los controladores se crean mediante el comando `php artisan make:controller`
8. **Establecer** las rutas de acceso a las funciones desarrolladas en los controladores mediante el archivo `routes/api.php`(Hay más información sobre el desarrollo de rutas [en este documento](RutasDeLaravel.md))

## Siguiente: [Registro y Autenticación de Usuarios](RegistroYAutenticacionEnLaravel.md)
