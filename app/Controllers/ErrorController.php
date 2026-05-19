<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct("Error");
    }

    public function index(?array $data): void
    {
        $errorCode = $data['errorCode'];

        echo $this->view->render("error", [
            "title" => ($errorCode ?? 404) . ' - Erro | Técnico - ' . APP_NAME,
            "errorCode" => $errorCode,
        ]);
    }
}