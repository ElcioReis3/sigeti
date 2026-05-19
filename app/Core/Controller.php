<?php

namespace App\Core;

use League\Plates\Engine;

class Controller
{
    protected ?Engine $view = null;

    public function __construct(string $pathView = "Web")
    {
        $this->view = new Engine(__DIR__ . "/../Views/" . $pathView, "php");
    }

    protected function validateCsrfToken(array $data, string $route): void
    {
        if (!$data || !csrf_verify($data['_csrf'] ?? null)) {
            Message::error("Token de segurança inválido");
            redirect($route);
            return;
        }
    }
}