<?php

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function csrf_input(): string
{
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="_csrf" value="' . $token . '">';
}

function csrf_verify(?string $token): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($token) || empty($_SESSION['_csrf'])) {
        return false;
    }

    $valid = hash_equals($_SESSION['_csrf'], $token);

    if ($valid) {
        unset($_SESSION['_csrf']);
    }

    return $valid;
}
