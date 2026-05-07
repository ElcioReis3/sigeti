<?php

namespace App\Controllers\Technical;


use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Category;
use App\Models\School;
use App\Models\SchoolUser;
use App\Models\Ticket;
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
        Auth::requirePermission(Permission::VIEW_ALL_TICKETS);
        $tickets = (new Ticket())->ticketsOrderedByStatusPriorityAndOpeningDate();
        $quantityTicketsByMonth = (new Ticket())->countTicketsByMonth(2024);

        echo $this->view->render("technical/ticket/index", [
            "tickets" => $tickets,
            "quantityTicketsByMonth" => $quantityTicketsByMonth,
        ]);


        clear_old();
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::OPEN_TICKET);
        $teachers = User::userByRole(User::TEACH);
        $schools = School::all();
        $categories = Category::all();

        echo $this->view->render("technical/ticket/create",[
            "teachers" => $teachers,
            "schools" => $schools,
            "categories" => $categories
        ]);
        clear_old();

    }

    public function status(?array $data): void
    {
        var_dump($data);

    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::OPEN_TICKET);
        $this->validateCsrfToken($data, "/tecnico/chamados/cadastrar");

        $data['status'] = Ticket::OPEN;

        $newTicket = new Ticket();

        try {

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
            }
            $newTicket->fill([
                "title" => $data["title"],
                "description" => $data["description"],
                "school_id"=>$data["school_id"],
                "category_id" => $data["category_id"],
                "opened_by"=> $data["opened_by"],
                "status" => $data["status"],
                "priority"=> $data["priority"],
            ]);


            $newTicket->setOpenedAt();
            $newTicket->save();


        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/chamados/cadastrar");
            return;
        }

        Message::success("Chamado cadastrado com sucesso!");
        redirect("/tecnico/chamados/editar/" . $newTicket->getId());
    }


    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_TICKET);
        $ticket = Ticket::find($data['id']);

        if(!$ticket){
            Message::warning("Esse Usuário não existe!");
            redirect("/tecnico/chamados");
            return;
        }

        $tickets = Ticket::all();
        $technicians = User::userByRole(User::TECHNICAL);

        echo $this->view->render("technical/ticket/edit", [
            "ticket" => $ticket,
            "tickets" => $tickets,
            "technicians" => $technicians,
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_TICKET);
        $this->validateCsrfToken($data, "/tecnico/chamados/editar/" . $data["id"]);

        $ticket = Ticket::find($data['id']);

        try {
            if(!$ticket){
                Message::error("Esse chamado não existe!");
                redirect("/tecnico/chamados");
                return;
            }

            $errors = array_merge(
                $ticket->validateTechnical($data),
                $ticket->validateStatusTransition($data["status"])
            );

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/tecnico/chamados/editar/" . $ticket->getId());
            }

            $ticket->fill([
                "assigned_to"=> $data["assigned_to"],
                "status" => $data["status"],
                "priority"=> $data["priority"],
            ]);

            if(in_array($data['status'], [Ticket::FINISHED, Ticket::ARCHIVED], true)){
                $ticket->setClosedAt();
            }

            $ticket->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/chamados/editar/" . $ticket->getId());
            return;
        }

        Message::success("Chamado atualizado com sucesso!");
        redirect("/tecnico/chamados/editar/" . $ticket->getId());

    }


    public function destroy(?array $data): void
    {
        Auth::requirePermission(Permission::DELETE_TICKET);
        try {
            $ticket = Ticket::find($data['id']);
            $ticket->delete();
            Message::success("Chamado removido com sucesso!");
            redirect("/tecnico/chamados");
            return;



        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/chamados");
            return;
        }
    }


}


