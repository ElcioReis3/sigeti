<?php

namespace App\Controllers;

use App\Core\Controller;

class WebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index():void
    {
        $title = "Home - " . APP_NAME;
        echo $this->view->render('home', [
            "title" => $title,
        ]);
    }
}