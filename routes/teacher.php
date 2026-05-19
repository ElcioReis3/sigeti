<?php

$router->group("/professor");
$router->get("/dashboard", "Teacher\\DashboardController@index");

/** Rotas de Chamados */
$router->get("/chamados", "Teacher\\TicketController@index");
$router->get("/chamados/cadastrar", "Teacher\\TicketController@create");
$router->post("/chamados/cadastrar", "Teacher\\TicketController@store");

/** Rotas de Comentários */
$router->get("/chamados/{ticket_id}/comentarios", "Teacher\\TicketCommentController@index");
$router->post("/chamados/{ticket_id}/comentarios", "Teacher\\TicketCommentController@store");

/** Rotas de Anexos */
$router->post("/chamados/{ticket_id}/anexos", "Teacher\\TicketAttachmentController@store");
$router->get("/chamados/{ticket_id}/anexos/download/{id}", "Teacher\\TicketAttachmentController@download");
$router->delete("/chamados/{ticket_id}/anexos/excluir/{id}", "Teacher\\TicketAttachmentController@destroy");
