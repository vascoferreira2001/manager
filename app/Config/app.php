<?php

return [
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', 'false') === 'true',
    'url' => env('APP_URL', 'http://localhost'),

    'locale' => env('APP_LOCALE', 'pt'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'key' => env('APP_KEY', ''),
];