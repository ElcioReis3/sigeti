<?php


use CoffeeCode\Router\Router;

$router = new Router( APP_URL, "@");
$router->namespace("app\Controllers");


// Profiles -> Rotas
$router->get("/perfil", "ProfileController@index");
$router->post("/perfil", "ProfileController@update");
$router->get("/seguranca", "ProfileController@security");
$router->post("/seguranca", "ProfileController@updatePassword");