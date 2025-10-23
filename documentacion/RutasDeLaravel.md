# Rutas en Laravel

## Contenido:

1. Uso de las rutas
1. El directorio `routes` y su contenido

---

## 1 - Uso de las rutas

Un proyecto en Laravel sigue los principios del patrón de diseño **MVC: Modelo, Vista, Controlador**.



Crearemos nuestras rutas de acuerdo al siguiente patrón:

    ```php
        Route::post(
            'uri/de/la/ruta',
            [Controlador::class, 'nombreDeLaFunción']
        )->middleware('guardia');
    ```

    O, alternativamente:

    ```php
        Route::middleware('guardia')->post(
            'uri/de/la/ruta',
            [Controlador::class, 'nombreDeLaFunción']
        );
    ```
> **Nota:** se denomina **URI**, o _Identificador Úniforme de Recurso_, a una _URL_ que permite acceder a un recurso o funcionalidad provistos por una aplicación web. Para más detalles, se recomienda leer [este artículo de MDN al respecto][l6].

[l6]: https://developer.mozilla.org/en-US/docs/Web/URI