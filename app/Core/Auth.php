<?php

namespace App\Core;

use App\Models\Role\RolePermission;

class Auth
{
    public static function user(): ?object
    {
        $session = new Session();
        return $session->auth ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function roleId(): ?int
    {
        $user = self::user();
        return isset($user->role_id) ? (int)$user->role_id : null;
    }

    public static function hasPermission(string $permission): bool
    {
        $roleId = self::roleId();

        if (!$roleId) {
            return false;
        }

        return RolePermission::userHasPermission($roleId, $permission);
    }

    public static function logout(): void
    {
        $session = new Session();
        $session->unset("auth");
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Message::warning("Você precisa fazer login para continuar.");
            redirect("/entrar");
            return;
        }

        SessionTimeoutMiddleware::handle();
    }

    public static function requirePermission(string $permission): void
    {
        self::requireLogin();

        if (!self::hasPermission($permission)) {
            redirect("/erro/403");
            return;
        }
    }
}