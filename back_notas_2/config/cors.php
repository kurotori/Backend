<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    //BACKEND: asegurarse de agregar a 'paths' las siguientes rutas de acceso
    'paths' => ['/*', 'api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    //BACKEND: Se deben habilitar las URL del frontend como orígenes habilitados
    'allowed_origins' => ['*', 'http://localhost:5173', 'http://127.0.0.1:5173'],

    'allowed_origins_patterns' => [],

    //BACKEND: Si estos headers se presonalizan, necesitamos asegurarnos que incluya 'x-xsrf-token'
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 300,

    //BACKEND: cambiar el valor de 'support_credentials'  a 'true'
    'supports_credentials' => true,

];
