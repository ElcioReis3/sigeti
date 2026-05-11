<?php


// Profiles -> Rotas
$router->get("/perfil", "ProfileController@index");
$router->post("/perfil", "ProfileController@update");
$router->get("/seguranca", "ProfileController@security");
$router->post("/seguranca", "ProfileController@updatePassword");