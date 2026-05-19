<?php

$router->group(null);

/** Perfil unificado — qualquer usuário autenticado */
$router->get("/perfil", "ProfileController@index");
$router->post("/perfil", "ProfileController@update");
$router->get("/seguranca", "ProfileController@security");
$router->post("/seguranca", "ProfileController@updatePassword");
