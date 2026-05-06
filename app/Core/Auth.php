<?php

namespace App\Core;

use App\Models\Role\RolePermission;

class Auth
{
    public static function user()
    {
        $session = new Session();
        return $session->auth ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function role(): ?string
    {
        $user = self::user();
        return $user->role ?? null;
    }

    public static function roleId(): ?int
    {
        $user = self::user();
        return isset($user->role_id) ? (int) $user->role_id : null;
    }

    public static function hasPermission(string $permission): bool
    {
        $roleId = self::roleId();

        if (!$roleId) {
            return false;
        }

        return RolePermission::userHasPermission($roleId, $permission);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Message::warning("Você não tem autorização de acesso a essa página.");
            redirect("/entrar");
        }
    }

    public static function requireRole(string $role): void
    {
        self::requireLogin();

        if (self::role() !== $role) {
            Message::error("Você não tem autorização de acesso a essa página.");
            redirect("/entrar");
        }
    }



    public static function requirePermission(string $permission): void
    {
        self::requireLogin();

        if (!self::hasPermission($permission)) {
            Message::error("Você não tem autorização para acessar esta página.");
            redirect("/erro/403");
            return;
        }
    }
}