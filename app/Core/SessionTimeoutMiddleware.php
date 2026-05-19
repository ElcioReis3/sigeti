<?php

namespace App\Core;

class SessionTimeoutMiddleware
{

    public const TIMEOUT = 60 * 60 * 2;

    public static function handle(): void
    {
        $loggedInAt = $_SESSION['logged_in_at'] ?? null;

        if (!$loggedInAt) {
            self::expireSession();
            return;
        }

        $sessionDuration = time() - $loggedInAt;

        if ($sessionDuration > self::TIMEOUT) {
            self::expireSession();
            return;
        }
    }

    public static function start(): void
    {
        $_SESSION['logged_in_at'] = time();
    }

    private static function expireSession(): void
    {
        $session = new Session();
        $session->unset("auth");
        $session->unset("logged_in_at");

        Message::warning("Sua sessão expirou. Faça login novamente.");
        redirect("/entrar");
        exit;
    }

}