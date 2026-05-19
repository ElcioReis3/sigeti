<?php

$router->group("/tecnico");
$router->get("/dashboard", "Technician\\DashboardController@index");

/** Rotas de Chamados */
$router->get("/chamados", "Technician\\TicketController@index");
$router->get("/chamados/cadastrar", "Technician\\TicketController@create");
$router->post("/chamados/cadastrar", "Technician\\TicketController@store");
$router->get("/chamados/editar/{id}", "Technician\\TicketController@edit");
$router->put("/chamados/editar/{id}", "Technician\\TicketController@update");
$router->delete("/chamados/excluir/{id}", "Technician\\TicketController@destroy");

/** Rotas de Comentários */
$router->get("/chamados/{ticket_id}/comentarios", "Technician\\TicketCommentController@index");
$router->post("/chamados/{ticket_id}/comentarios", "Technician\\TicketCommentController@store");
$router->put("/chamados/{ticket_id}/comentarios/editar/{id}", "Technician\\TicketCommentController@update");
$router->delete("/chamados/{ticket_id}/comentarios/excluir/{id}", "Technician\\TicketCommentController@destroy");

/** Rotas de Anexos */
$router->post("/chamados/{ticket_id}/anexos", "Technician\\TicketAttachmentController@store");
$router->get("/chamados/{ticket_id}/anexos/download/{id}", "Technician\\TicketAttachmentController@download");
$router->delete("/chamados/{ticket_id}/anexos/excluir/{id}", "Technician\\TicketAttachmentController@destroy");
