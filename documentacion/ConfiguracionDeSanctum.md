# Configuración Del Sanctum

Para lograr una adecuada autenticación, nuestro backen **debe expedir `cookies`** que deben ser corectamente aceptadas y reconocidas por el frontend. Para ello debemos configurarlo.

1. **Asegurarse** de que el archivo `config/sanctum.php`([ver en archivo][l1]) tiene las siguientes propiedades:
   - Contiene el atributo `stateful`, y que este incluye **_de forma explícita_** el dominio del frontend (usar).

    En general, si estamos trabajando con _Vue_, el atributo `stateful` será semejante a lo siguiente:

    ~~~php
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,127.0.0.1:5173,localhost:5173::1',
        Sanctum::currentApplicationUrlWithPort(),
    ))),
    ~~~

    - Contiene el el atributo `support_credentials`, y que su valor es `true`

2. Agregar el atributo **HasApiTokens** al modelo de usuario (**_/app/Http/Models/User.php_**) ([ver en el archivo][l2]) para facilitar el uso de tokens de `sanctum` con el mismo.

3. **IMPORTANTE:** Es muy necesario **configurar adecuadamente** la instancia de **Axios** en el frontend para que **solicite la cookie CSRF**, y que las rutas de solicitud en frontend y backend **siempre** apuntan al servidor de forma correcta (o sea, **seimpre** usar `localhost` en vez de `127.0.0.1`)

4. **Configurar** en el archivo `bootstrap/app.php` ([ver en el archivo][l3]), el middleware `statefulApi` de la siguiente manera:

   ~~~php
   ->withMiddleware(function (Middleware $middleware) {
         // otro código pre-existenteRegistroYAutenticacionEnLaravel.md

        $middleware->statefulApi();

         // otro código pre-existente
    })
   ~~~

5. Configurar en el archivo `config/session.php` ([ver en el archivo][l4]) las siguientes propiedades con estos valores:
   - `secure`, agregar parámetro `true`
   - `http_only`, agregar parámetro `true`
   - `same_site`, establecer a `lax`
   - `partitioned`, agregar parámetro `true`

6. Configurar en el archivo `config/cors.php` ([ver en el archivo][l6]) las siguientes propiedades:
   - `paths`: Debe contener las rutas habilitadas donde se esperan solicitudes, y además la ruta donde `sanctum` entrega la `cookie` para evitar ataques XSRF, por ejemplo:

      ~~~php
      'paths' => ['/*', 'api/*', 'sanctum/csrf-cookie'],
      ~~~

   - `allowed_origins`: Debe contener las URLs del frontend, por ejemplo:

      ~~~php
      'allowed_originssupport_credentials' => ['*', 'http://localhost:5173', 'http://127.0.0.1:5173'],   
      ~~~

   - `support_credentials`: Se debe establecer en `true` para habilitar el envío de credenciales (las `cookies` que le aseguran al backend que la conexión es confiable) para la autenticación.
   > **Nota:** El archivo `config/cors.php` establece el manejo del _Intercambio de Recursos de Origen Cruzado_ (en inglés: _Cross-Origin Resource Sharing_) y es una medida de seguridad que permite establecer cuáles son los dominios confiables para el backend como orígen de datos. Se puede leer más al respecto [en el sitio de MDN][l7].

Ahora `sanctum` debería ser capaz de expedir cookies correctamente configuradas.

## Siguiente: [Registro y Autenticación][l5]

[l1]:../back_notas_2/config/sanctum.php
[l2]:../back_notas_2/app/Models/User.php
[l3]:../back_notas_2/bootstrap/app.php
[l4]:../back_notas_2/config/session.php
[l5]:RegistroYAutenticacionEnLaravel.md
[l6]:../back_notas_2/config/cors.php
[l7]:https://developer.mozilla.org/es/docs/Web/HTTP/Guides/CORS
