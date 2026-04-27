<?php
namespace App\Core;

class Session
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_save_path(__DIR__ . "/../../storage/sessions");

            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'domain'   => '',
                'secure'   => false, // mude para true em produção com HTTPS
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            session_start();
        }
    }

    public function __set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function __get(string $name)
    {
        return $_SESSION[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return $this->has($name);
    }

    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    public function get(string $key): mixed
    {
        return isset($_SESSION[$key]) ? (object)$_SESSION[$key] : null;
    }

    public function set(string $key, mixed $value): self
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    public function unset(string $key): self
    {
        unset($_SESSION[$key]);
        return $this;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function regenerate(): self
    {
        session_regenerate_id(true);
        return $this;
    }

    public function destroy(): self
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        return $this;
    }
}