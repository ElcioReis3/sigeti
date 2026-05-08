<?php


use CoffeeCode\Router\Router;

$router = new Router( APP_URL, "@");
$router->namespace("app\Controllers");


// Profiles -> Rotas
$router->get("/profile", "");