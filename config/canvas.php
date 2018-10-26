<?php

use Canvas\Http\Middleware\Authorize;

return [

    /*
    |--------------------------------------------------------------------------
    | Public Path
    |--------------------------------------------------------------------------
    |
    | You are free to expose the public-facing blog to any route you wish.
    | If no change is made then it will default to the /blog path of
    | your application.
    |
    */

    'public_path' => 'blog',

    /*
    |--------------------------------------------------------------------------
    | Canvas Middleware
    |--------------------------------------------------------------------------
    |
    | You may assign any custom middleware that you choose to the /canvas
    | routes in your application. They will be protected by basic
    | user authentication by default.
    |
    */

    'middleware' => [
        'web',
        Authorize::class,
    ],

];
