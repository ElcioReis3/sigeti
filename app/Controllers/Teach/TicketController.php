<?php

namespace App\Controllers\Teach;


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

        Auth::requirePermission(Permission::OPEN_TICKET);
    }

    public function index(): void
    {
        $tickets = (new Ticket())->ticketsOrderedByStatusPriorityAndOpeningDateByUser(Auth::user()->id);
        $schools = SchoolUser::linksByUser(Auth::user()->id);
        echo $this->view->render("teach/ticket/index", [
            "tickets" => $tickets,
            "schools" => $schools,
        ]);


        clear_old();
    }

    public function create(): void
    {
        $categories = Category::all();
        $links = SchoolUser::linksByUser(Auth::user()->id);

        $schools = [];

        foreach ($links as $link) {
            $schools[] = School::find($link->getSchoolId());
        }

        echo $this->view->render("teach/ticket/create", [
            "categories" => $categories,
            "schools" => $schools,
        ]);

        clear_old();

    }

    public function status(?array $data): void
    {
        var_dump($data);

    }

    public function store(?array $data): void
    {
        $this->validateCsrfToken($data, "/professor/chamados/cadastrar");

        $loggedUser = User::find(Auth::user()->id);
        $userSchools = $loggedUser->schoolUserLinks();

        if (empty($userSchools)) {
            Message::warning("Você não está vinculado a nenhuma escola. Contacte o administrador.");
            redirect("/professor/chamados/cadastrar");
            return;
        }

        if (count($userSchools) === 1) {

            $schoolId = $userSchools[0]->getSchoolId();

        } else {

            if (!$data["school_id"]) {
                Message::warning("Selecione a escola para o chamado.");
                redirect("/professor/chamados/cadastrar");
                return;
            }

            $schoolIds = [];

            /** @var SchoolUser $link */
            foreach ($userSchools as $link) {
                $schoolIds[] = $link->getSchoolId();
            }

            if (!in_array($data['school_id'], $schoolIds, true)) {
                Message::warning("A escola selecionada não pertence ao seu vínculo.");
                redirect("/professor/chamados/cadastrar");
                return;
            }

            $schoolId = $data["school_id"];
        }

        $ticket = new Ticket();

        $payload = [
            "title" => $data["title"] ?? null,
            "description" => $data["description"],
            "school_id" => $schoolId,
            "category_id" => $data["category_id"],
            "opened_by" => $loggedUser->getId(),
            "status" => Ticket::OPEN,
            "priority" => Ticket::MEAN,
        ];

        $errors = array_merge(
            $ticket->validate($payload),
            $ticket->validateBusinessRulesForTeacher($payload)
        );

        if ($errors) {

            flash_old($data);

            foreach ($errors as $error) {
                Message::warning($error);
            }
            redirect("/professor/chamados/cadastrar");
            return;
        }

        try {

            $ticket->fill($payload);
            $ticket->setOpenedAt();
            $ticket->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {

            Message::error($invalidArgumentException->getMessage());
            redirect("/professor/chamados/cadastrar");
            return;
        }

        Message::success("Chamado aberto com sucesso.");
        redirect("/professor/chamados/" . $ticket->getId() . "/comentarios");
    }


    public function edit(?array $data): void
    {
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


