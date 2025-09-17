# Documentación: Desarrollo de un Backend para un frontend Vue

1. **Instalar** los requerimientos para el desarrollo de Laravel mediante [el comando indicado en la documentación oficial](https://laravel.com/docs/12.x/installation). ***Se debe cerrar y volver a abrir la consola para el siguiente paso.***
2. **Generar** el proyecto con el comando `laravel new`
3. **Configurar el proyecto como Backend**:
    - Agregar librerías y acceso al archivos de rutas de API con el comando `php artisan install:api`
4. **Añadir** el atributo `HasApiTokens` al modelo de usuario ([ver archivo](../app/Models/User.php))
5. **Definir** las estructuras de la base de datos mediante migraciones, y crear los modelos correspondientes. Por conveniencia, se recomienda crear los modelos e indicar, *en el mismo comando*, que se creen las migraciones correspondientes.
Por ejemplo, para un modelo llamado `Cosa`, el comando sería: `php artisan make:model Cosa -m`
