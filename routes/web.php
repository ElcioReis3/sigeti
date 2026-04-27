<?php


use CoffeeCode\Router\Router;

$router = new Router( APP_URL, "@");
$router->namespace("app\Controllers");


$router->get('/', "WebController@index");

// USUARIOS
$router->get('/usuarios', "UserController@index");

// ENTRAR
$router->get('/entrar', "AuthController@index");
$router->post('/entrar', "AuthController@authenticate");

//CADASTRO
$router->get('/cadastrar', "AuthController@create");
$router->get("/cadastrar/sucesso", "AuthController@storeSucess");
$router->post('/cadastrar', "AuthController@store");



//REDEFINIR SENHA
$router->get('/redefinir-senha', "AuthController@forgotPassword");
$router->post('/redefinir-senha', "AuthController@sendResetLink");
$router->get("/redefinir-senha/sucesso", "AuthController@sendResetLinkSuccess");
$router->get('/resetar-senha/{token}', "AuthController@resetPassword");
$router->post('/resetar-senha', "AuthController@updatePassword");



// ROLE - PROFESSOR
$router->group(null);
$router->get("/professor/dashboard", "Teach\\DashboardController@index");

// SAIR
$router->post("/sair", "AuthController@logout");

// Rotas do Técnico
$router->group("/tecnico");
$router->get("/dashboard", "Technical\\DashboardController@index"); // /tecnico/dashboard
$router->get("/categorias", "Technical\\CategoryController@index");
$router->get("/categorias/cadastrar", "Technical\\CategoryController@create");
$router->post("/categorias/cadastrar", "Technical\\CategoryController@store");
$router->get("/categorias/editar/{id}", "Technical\\CategoryController@edit");
$router->put("/categorias/editar/{id}", "Technical\\CategoryController@update");
$router->delete("/categorias/excluir/{id}", "Technical\\CategoryController@destroy");



$router->get("/escolas", "Technical\\SchoolController@index");
$router->get("/escolas/cadastrar", "Technical\\SchoolController@create");
$router->post("/escolas/cadastrar", "Technical\\SchoolController@store");
$router->get("/escolas/editar/{id}", "Technical\\SchoolController@edit");
$router->put("/escolas/editar/{id}", "Technical\\SchoolController@update");
$router->delete("/escolas/excluir/{id}", "Technical\\SchoolController@destroy");


$router->get("/usuarios", "Technical\\UserController@index");
$router->get("/usuarios/cadastrar", "Technical\\UserController@create");
$router->post("/usuarios/cadastrar", "Technical\\UserController@store");
$router->get("/usuarios/editar/{id}", "Technical\\UserController@edit");
$router->put("/usuarios/editar/{id}", "Technical\\UserController@update");
$router->delete("/usuarios/excluir/{id}", "Technical\\UserController@destroy");

$router->get("/chamados", "Technical\\TicketController@index");
//$router->get("/chamados/{status}", "Technical\\TicketController@status");
$router->get("/chamados/cadastrar", "Technical\\TicketController@create");
$router->post("/chamados/cadastrar", "Technical\\TicketController@store");
$router->get("/chamados/editar/{id}", "Technical\\TicketController@edit");
$router->put("/chamados/editar/{id}", "Technical\\TicketController@update");
$router->delete("/chamados/excluir/{id}", "Technical\\TicketController@destroy");

// Technical -> Rotas para comentários
$router->get("/chamados/{ticket_id}/comentarios", "Technical\\TicketCommentController@index");
$router->post("/chamados/{ticket_id}/comentarios", "Technical\\TicketCommentController@store");
$router->post("/chamados/{ticket_id}/comentarios/excluir/{id}", "Technical\\TicketCommentController@destroy");



$router->group("/professor");
$router->get("/dashboard", "Teach\\DashboardController@index"); // /tecnico/dashboard
$router->get("/chamados", "Teach\\TicketController@index");
$router->get("/chamados/cadastrar", "Teach\\TicketController@create");
$router->post("/chamados/cadastrar", "Teach\\TicketController@store");

// Teach -> Rotas para comentários
$router->get("/chamados/{ticket_id}/comentarios", "Teach\\TicketCommentController@index");
$router->post("/chamados/{ticket_id}/comentarios", "Teach\\TicketCommentController@store");


$router->dispatch();
if($router->error()){
    echo "<h1> Erro: {$router->error()}</h1>";
}