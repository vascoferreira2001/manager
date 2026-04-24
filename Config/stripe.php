<?php

return [
    'secret' => $_ENV['STRIPE_SECRET'] ?? '',
    'public' => $_ENV['STRIPE_PUBLIC'] ?? '',
    'webhook_secret' => $_ENV['STRIPE_WEBHOOK_SECRET'] ?? ''
];