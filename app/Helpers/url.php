<?php

function url(string $path = null): string
{
    $base = APP_URL;

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}

function redirect(string $path): void
{
    header("Location: " . url($path));
    exit;
}

function assets(string $path = null): string
{
    $base = APP_URL . "/public/assets";

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}

function assets_sb_admin(string $path = null): string
{
    $base = APP_URL . "/resources/themes/startbootstrap-sb-admin-2-gh-pages";

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}

function assets_flex_start(string $path = null): string
{
    $base = APP_URL . "/resources/themes/FlexStart-1.0.0";

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}

function assets_mazer(string $path = null): string
{
    $base = APP_URL . "/resources/themes/dist";

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}
