<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class WebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
    {
        echo $this->view->render("home", [
            "title" => "Home | " . APP_NAME
        ]);
    }
}