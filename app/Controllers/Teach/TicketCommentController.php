<?php

namespace App\Controllers\Teach;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Models\SchoolUser;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;


class TicketCommentController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole(User::TEACH);
    }


    public function index(?array $data): void
    {
        $ticket = Ticket::find((int) $data['ticket_id']);
        $comments = TicketComment::commentsByTicketId($data['ticket_id']);

        if (!$ticket || Auth::user()->id !== $ticket->getOpenedBy()) {
            Message::warning("Chamado não encontrado ou não existe.");
            redirect("/professor/chamados");
            return;
        }

        echo $this->view->render("teach/ticket/comments", [
            "comments" => $comments,
            "ticket" => $ticket
        ]);

        clear_old();
    }


    public function store(?array $data): void
    {
        $ticketId = (int)($data["ticket_id"] ?? 0);

        $this->validateCsrfToken($data, "/professor/chamados/{$ticketId}/comentarios");

        $ticket = Ticket::find($ticketId);

        if (!$ticket || Auth::user()->id !== $ticket->getOpenedBy()) {
            Message::warning("Chamado não encontrado ou não existe.");
            redirect("/professor/chamados");
            return;
        }

        $comment = new TicketComment();

        $payload = [
            "ticket_id" => $ticketId,
            "user_id" => Auth::user()->id,
            "comment" => $data["comment"],
        ];


        $errors = array_merge(
            $comment->validate($payload),
            $comment->validateBusinessRules($payload)
        );

        if ($errors) {
            flash_old($data);

            foreach ($errors as $error) {
                Message::warning($error);
            }

            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        try {
            $comment->fill($payload);
            $comment->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        Message::success("Comentário adicionado com sucesso.");
        redirect("/professor/chamados/{$ticketId}/comentarios");
    }


}