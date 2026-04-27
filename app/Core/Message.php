<?php

namespace App\Core;

class Message
{
    private const KEY = '_flash';

    public static function primary(string $message, string $code = null): void
    {
        self::set('primary', $message, $code);
    }

    public static function success(string $message, string $code = null): void
    {
        self::set('success', $message, $code);
    }

    public static function warning(string $message, string $code = null): void
    {
        self::set('warning', $message, $code);
    }

    public static function error(string $message, string $code = null): void
    {
        self::set('danger', $message, $code);
    }

    public static function dark(string $message, string $code = null): void
    {
        self::set('dark', $message, $code);
    }

    public static function secondary(string $message, string $code = null): void
    {
        self::set('secondary', $message, $code);
    }

    public static function light(string $message, string $code = null): void
    {
        self::set('light', $message, $code);
    }

    public static function info(string $message, string $code = null): void
    {
        self::set('info', $message, $code);
    }

    private static function set(string $type, string $message, ?string $code): void
    {
        $defaultCodes = [
            'primary' => 'Resultado:',
            'success' => 'Sucesso:',
            'warning' => 'Atenção:',
            'danger' => 'Erro:',
            'info' => 'Informação:',
            'secondary' => 'Aviso:',
            'light' => 'Nota:',
            'dark' => 'Sistema:'
        ];

        $_SESSION[self::KEY][] = [
            'type' => $type,
            'message' => $message,
            'code' => $code ?? ($defaultCodes[$type] ?? null)
        ];
    }

    public static function get(): ?array
    {
        if (!empty($_SESSION[self::KEY])) {
            $flash = $_SESSION[self::KEY];
            unset($_SESSION[self::KEY]);
            return $flash;
        }

        return null;
    }

    public static function render(): ?string
    {
        $flash = self::get();
        if (!$flash) {
            return null;
        }

        $html = '';
        foreach ($flash as $item) {
            $code = $item['code']
                ? "<strong>" . self::escape($item['code']) . "</strong> "
                : "";

            $html .= "<div class='alert alert-{$item['type']} alert-dismissible fade show' role='alert'>
                    {$code}" . self::escape($item['message']) . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        }

        return $html;
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}