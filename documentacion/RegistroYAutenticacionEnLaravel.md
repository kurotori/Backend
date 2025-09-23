# Registro y Autenticación de Usuarios en Laravel

## 1 - Registro de Usuarios

### A - Configuración del Controlador

Si configuramos el proyecto de Laravel como se mencionó [al comienzo de esta documentación][l1], nuestro proyecto debería contar con un directorio llamado `Auth` en `app/Http/Controllers` ([ver en el proyecto][l2]).
Este directorio contiene controladores que nos serán útiles para el registro de usuarios en nuestro sistema, particularmente [`RegisteredUserController.php`][l3].

En este controlador encontraremos la función `store`, que usaremos para registrar un usuario nuevo, con algunas modificaciones, ya que la función original redirige a una página interna (asume que estamos desarrollando un proyecto que incluye frontend y backend en el mismo paquete). Por este motivo, comentaremos las siguientes líneas de código:

1. En la declaración de la función `store`, comentamos el tipo de datos de retorno `RedirectResponse`:

    ~~~php
        public function store(Request $request) //:RedirectResponse
    ~~~

2. En el cuerpo de la función `store`, comentamos el `return to_route` que se encuentra al final:

    ~~~php
         //return to_route('dashboard');
    ~~~

### B - Configuración de la Ruta

En el archivo `routes/api.php` ([ver en el archivo][l4]) declararemos una ruta de tipo `post`  


[l1]:README.md
[l2]:../back_notas_2/app/Http/Controllers/Auth/
[l3]:../back_notas_2/app/Http/Controllers/Auth/RegisteredUserController.php
[l4]:../back_notas_2/routes/api.php