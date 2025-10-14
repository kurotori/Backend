# Autenticación de Usuarios en Laravel

1. [Configuración del Controlador](#1---configuración-del-controlador)
2. [Configuración de la Ruta](#b---configuración-de-la-ruta)
3. [Proceso de Registro de Usuarios](#c---proceso-de-registro-de-usuarios)

## 1 - Configuración del Controlador

Como toda fucionalidad del backend, la debemos manejar mediante un **controlador**.

La instalación del _starter-kit_ de _Vue_ nos a dejado varios controladores que manejan muchas de las funcionalidades necesarias en el directorio [app/Http/Controllers/Auth][l1]. 

Lamentablemente, estas funcionalidades estan pensadas para trabajar con vistas en un proyecto de _Laravel_ con frontend incluído, y no podemos usarlas directamente si queremos usar nuestro proyecto _solo_ como backend .

Pero podemos tomarlos como referencia para nuestras propias funciones.

Crearemos un controlador desde la consola con el comando

```sh
    php artisan make:controller
```




[l1]: ../back_notas_2/app/Http/Controllers/Auth/
