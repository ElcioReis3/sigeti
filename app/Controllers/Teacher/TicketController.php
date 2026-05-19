<?php

namespace App\Controllers\Teacher;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Category;
use App\Models\Department\Department;
use App\Models\Department\UserDepartment;
use App\Models\Ticket\Ticket;

class TicketController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::OPEN_TICKET);
    }

    public function index(): void
    {
        $tickets = (new Ticket())->allOrderedByUser(Auth::user()->id);

        echo $this->view->render("teacher/ticket/index", [
            "tickets" => $tickets
        ]);

        clear_old();
    }

    public function create(): void
    {
        $categories = Category::all();
        $departmentsUser = UserDepartment::linksByUser(Auth::user()->id);
        $departments = [];

        /** @var UserDepartment $departmentUser */
        foreach ($departmentsUser as $departmentUser) {
            $departments[] = Department::find($departmentUser->getDepartmentId());
        }

        echo $this->view->render("teacher/ticket/create", [
            "categories" => $categories,
            "departments" => $departments,
        ]);

        clear_old();
    }

    public function store(?array $data): void
    {
        $this->validateCsrfToken($data, "/professor/chamados/cadastrar");

        $loggedUser = \App\Models\User::find(Auth::user()->id);

        $userDepartments = $loggedUser->departmentUserLinks();

        if (empty($userDepartments)) {
            Message::warning("Você não está vinculado a nenhum departamento. Contate o administrador.");
            redirect("/professor/chamados/cadastrar");
            return;
        }

        if (count($userDepartments) === 1) {

            $departmentId = $userDepartments[0]->getDepartmentId();

        } else {

            if (empty($data["department_id"])) {
                Message::warning("Selecione o departamento para o chamado.");
                redirect("/professor/chamados/cadastrar");
                return;
            }

            $departmentIds = array_map(
                static fn(UserDepartment $link) => $link->getDepartmentId(),
                $userDepartments
            );

            if (!in_array((int)$data["department_id"], $departmentIds, true)) {
                Message::warning("O departamento selecionado não pertence ao seu vínculo.");
                redirect("/professor/chamados/cadastrar");
                return;
            }

            $departmentId = (int)$data["department_id"];
        }

        $ticket = new Ticket();

        $payload = [
            "title"         => $data["title"] ?? null,
            "description"   => $data["description"] ?? null,
            "department_id" => $departmentId,
            "category_id"   => $data["category_id"] ?? null,
            "opened_by"     => $loggedUser->getId(),
            "status"        => Ticket::OPEN,
            "priority"      => Ticket::MEAN,
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
}