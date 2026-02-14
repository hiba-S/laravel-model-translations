<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Auto-load translations relation
    |--------------------------------------------------------------------------
    |
    | If true, the "translations" relation will be automatically eager loaded
    | using a global scope.
    |
    */

    'auto_load' => true,

    /*
    |--------------------------------------------------------------------------
    | Fallback Strategy
    |--------------------------------------------------------------------------
    |
    | Possible values:
    |
    | null       => No fallback, return null
    | 'app'      => Use config('app.fallback_locale')
    | 'first'    => Use first available translation
    |
    */

    'fallback' => 'app',
];
