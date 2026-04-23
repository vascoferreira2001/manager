<?php

// Segurança de sessão
session_set_cookie_params([
    'httponly' => true,
    'secure' => false, // true em produção com HTTPS
    'samesite' => 'Strict'
]);

session_start();

// Regenerar sessão
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}