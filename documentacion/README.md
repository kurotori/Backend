# Documentación: Desarrollo de un Backend _Laravel_ para un frontend _Vue_

Esta serie de documentos contiene los pasos básicos para desarrollar un backend de _Laravel 12_ para un frontend desarrollado en _Vue 3_, y se complementa con los archivos contenidos en el directorio [**back_notas_2**][l6] de este repositorio, y con la documentación del desarrollo del frontend en el repositorio [**Frontend**][l7]

Estos documentos complementan el contenido de la **[Guía de Desarrollo de APIs REST con Laravel][l9]**.

> **Nota:** En los archivos mencionados por estos documentos se pueden ubicar los cambios mencionados **buscando los comentarios** que comienzan por la palabra clave `BACKEND` de la siguiente forma:

~~~php
   //BACKEND: 
~~~

1. **Instalar** los requerimientos para el desarrollo de Laravel mediante [el comando indicado en la documentación oficial][l1].

   > **NOTA: _Se debe cerrar y volver a abrir la consola para poder continuar._**

2. **Generar** el proyecto con el comando `laravel new`, con las siguientes opciones:
   - Nombre del proyecto: **A elección**, pero se recomienda seguir la convención de nombres de `Laravel` ([ver esta publicación para más detalles][l8])
   - Starter kit: **Vue**
   - Autenticación: **Laravel built-in**
   - Testing framework: **PHPUnit**
   > **Nota:** No es realmente necesaria la ejecución del comando `npm install` al finalizar

3. **Configurar el proyecto como Backend**:
   - Agregar librerías y acceso al archivos de rutas de API con el comando `php artisan install:api`
   - Exponer el archivo `config\cors.php`mediante el comando `php artisan config:publish cors`

4. **Añadir** el atributo `HasApiTokens` al modelo de usuario ([ver archivo][l2])

5. **Definir** las estructuras de la base de datos mediante migraciones, y crear los modelos correspondientes. Por conveniencia, se recomienda crear los modelos e indicar, _en el mismo comando_, que se creen las migraciones correspondientes.
   Por ejemplo, para un modelo llamado `Cosa`, el comando sería: `php artisan make:model Cosa -m`
   De lo contrario, **es posible crear migraciones de forma individual** con el comando `php artisan make:migration`
   **Y los modelos** mediante el comando `php artisan make:model`
   Luego de definir las migraciones, se debe ejecutar el comando `php artisan migrate` para que se apliquen sus cambios a la base de datos del sistema. 
   > (Hay más información sobre el manejo de bases de datos [en este documento][l3])

6. **Configurar** las características de los modelos (campos rellenables, campos ocultos, relaciones entre modelos, etc.)

7. **Crear y configurar los controladores** definiendo las funciones que hagan falta. Los controladores se crean mediante el comando `php artisan make:controller`

8. **Establecer** las rutas de acceso a las funciones desarrolladas en los controladores mediante el archivo `routes/api.php`(Hay más información sobre el desarrollo de rutas [en este documento][l4])

## Siguiente: [Configuración de Sanctum][l5]

[l1]:https://laravel.com/docs/12.x/installation
[l2]:../app/Models/User.php
[l3]:BasesDeDatosEnLaravel.md
[l4]:RutasDeLaravel.md
[l5]:ConfiguracionDeSanctum.md
[l6]:../back_notas_2/
[l7]:https://github.com/kurotori/Frontend/tree/main/EjemplosBase/notas-base
[l8]:https://github.com/alexeymezenin/laravel-best-practices/blob/master/spanish.md#sigue-la-convenci%C3%B3n-de-laravel-para-los-nombres
[l9]:https://docs.google.com/document/d/e/2PACX-1vQeM-NoqZRWMX-9AZqMNgVnXInmweh8gW9d6Xi-SrguWBC9MrpVztjvAvDOT3LdwImd7QYJMxvzQGwG/pub