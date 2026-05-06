<?php


namespace App\Controllers\Technical;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\School;
use App\Models\User;

class SchoolController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_SCHOOLS);
    }

    public function index(): void
    {
        $schools = School::all();

        echo $this->view->render("technical/school/index", [
            "schools" => $schools
        ]);
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::CREATE_SCHOOL);
        echo $this->view->render("technical/school/create");
    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_SCHOOL);
        $this->validateCsrfToken($data, "/tecnico/escolas/cadastrar");

        $newSchool = new School();

        try {
            $newSchool->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "address" => $data["address"],
            ]);

            $errors = array_merge(
                $newSchool->validate($data),
                $newSchool->validateBusinessRule()
            );

            if ($errors) {
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/tecnico/escolas/cadastrar");
            }

            $newSchool->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/escolas/cadastrar");
            return;
        }

        Message::success("Escola cadastrada com sucesso!");
        redirect("/tecnico/escolas/editar/" . $newSchool->getId());
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_SCHOOL);
        $school = School::find($data["id"]);

        if (!$school) {
            Message::warning("Essa escola não existe!");
            redirect("/tecnico/escolas");
            return;
        }

        echo $this->view->render("technical/school/edit", [
            "school" => $school
        ]);
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_SCHOOL);
        $this->validateCsrfToken($data, "/tecnico/escolas/editar/" . $data['id']);

        $school = School::find($data["id"]);

        if (!$school) {
            Message::error("Essa escola não existe!");
            redirect("/tecnico/escolas");
            return;
        }

        try {

            $school->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "address" => $data["address"],
            ]);

            $errors = array_merge(
                $school->validate($data),
                $school->validateBusinessRule($school->getId())
            );

            if ($errors) {
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/tecnico/escolas/editar/" . $school->getId());
            }

            $school->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/escolas/editar/" . $school->getId());
            return;
        }

        Message::success("Escola atualizada com sucesso!");
        redirect("/tecnico/escolas/editar/" . $school->getId());
    }
}