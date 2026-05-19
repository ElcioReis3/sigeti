<?php

namespace App\Controllers\Technician;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Category;
use App\Models\Department\Department;
use App\Models\Ticket\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::VIEW_ALL_TICKETS);
    }

    public function index(): void
    {
        echo $this->view->render("technician/ticket/index", [
            "tickets" => (new Ticket())->allOrdered()
        ]);

        clear_old();
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::OPEN_TICKET);

        echo $this->view->render("technician/ticket/create", [
            "departments" => (new Department())->orderBy('name','ASC')->get(),
            "categories" => Category::all(),
            "users" => User::all(),
        ]);

        clear_old();
    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::OPEN_TICKET);

        $this->validateCsrfToken($data, "/tecnico/chamados/cadastrar");

        $data["status"] = Ticket::OPEN;
        $newTicket = new Ticket();

        $errors = array_merge(
            $newTicket->validate($data),
            $newTicket->validateBusinessRules($data)
        );

        if ($errors) {
            flash_old($data);
            foreach ($errors as $error) {
                Message::warning($error);
            }
            redirect("/tecnico/chamados/cadastrar");
            return;
        }

        try {
            $newTicket->fill([
                "title" => $data["title"],
                "description" => $data["description"],
                "department_id" => $data["department_id"],
                "category_id" => $data["category_id"],
                "opened_by" => $data["opened_by"],
                "status" => $data["status"],
                "priority" => $data["priority"],
            ]);
            $newTicket->setOpenedAt();
            $newTicket->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/chamados/cadastrar");
            return;
        }

        Message::success("Chamado cadastrado com sucesso.");
        redirect("/tecnico/chamados/editar/" . $newTicket->getId());
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_TICKET);

        $ticket = Ticket::find($data["id"]);

        if (!$ticket) {
            Message::warning("Chamado não encontrado ou não existe.");
            redirect("/tecnico/chamados");
            return;
        }

        echo $this->view->render("technician/ticket/edit", [
            "ticket" => $ticket,
            "departments" => Department::all(),
            "categories" => Category::all(),
            "technicians" => User::usersByPermission(Permission::TAKE_TICKET)
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_TICKET);

        $this->validateCsrfToken($data, "/tecnico/chamados/editar/" . $data["id"]);

        $ticket = Ticket::find((int)$data["id"]);

        if (!$ticket) {
            Message::warning("Chamado não encontrado ou não existe.");
            redirect("/tecnico/chamados");
            return;
        }

        $newStatus = $data["status"] ?? $ticket->getStatus();
        $errors = $ticket->validateStatusTransition($newStatus);

        if ($errors) {
            flash_old($data);
            foreach ($errors as $error) {
                Message::warning($error);
            }
            redirect("/tecnico/chamados/editar/" . $ticket->getId());
            return;
        }

        try {
            $ticket->fill([
                "status" => $newStatus,
                "priority" => $data["priority"] ?? $ticket->getPriority(),
            ]);

            if (!empty($data["assigned_to"])) {
                $ticket->setAssignedTo((int)$data["assigned_to"]);
            }

            if (in_array($newStatus, [Ticket::FINISHED, Ticket::ARCHIVED], true)) {
                $ticket->setClosedAt();
            }

            $ticket->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/chamados/editar/" . $ticket->getId());
            return;
        }

        Message::success("Chamado atualizado com sucesso.");
        redirect("/tecnico/chamados/editar/" . $ticket->getId());
    }

    public function destroy(?array $data): void
    {
        Auth::requirePermission(Permission::DELETE_TICKET);

        $this->validateCsrfToken($data, "/tecnico/chamados");

        $ticket = Ticket::find((int)$data["id"]);

        if (!$ticket) {
            Message::warning("Chamado não encontrado ou não existe.");
            redirect("/tecnico/chamados");
            return;
        }

        if ($ticket->existsComments()) {
            Message::warning("Este chamado possui comentários vinculados e não pode ser excluído.");
            redirect("/tecnico/chamados");
            return;
        }

        $blockDelete = [
            Ticket::IN_PROGRESS,
            Ticket::WAITING,
            Ticket::RESOLVED,
            Ticket::FINISHED,
        ];

        if (in_array($ticket->getStatus(), $blockDelete, true)) {
            $labels = [
                Ticket::IN_PROGRESS => "Em Andamento",
                Ticket::WAITING => "Aguardando",
                Ticket::RESOLVED => "Resolvido",
                Ticket::FINISHED => "Finalizado",
            ];
            Message::warning("Chamados com status '{$labels[$ticket->getStatus()]}' não podem ser excluídos.");
            redirect("/tecnico/chamados");
            return;
        }

        try {
            $ticket->delete();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/chamados");
            return;
        }

        Message::success("Chamado excluído em segurança com sucesso.");
        redirect("/tecnico/chamados");
    }
}