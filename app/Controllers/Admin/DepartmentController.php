<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Department\Department;

class DepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::VIEW_DEPARTMENTS);
    }

    public function index(): void
    {
        $departments = (new Department())->orderBy("name", "ASC")->get();

        echo $this->view->render("admin/department/index", [
            "departments" => $departments,
        ]);

        clear_old();
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::CREATE_DEPARTMENT);

        echo $this->view->render("admin/department/create");
        clear_old();
    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_DEPARTMENT);

        $this->validateCsrfToken($data, "/admin/departamentos/cadastrar");

        $newDepartment = new Department();

        try {
            $newDepartment->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "description" => $data["description"] ?? null,
                "address" => $data["address"] ?? null,
            ]);

            $errors = array_merge(
                $newDepartment->validate($data),
                $newDepartment->validateBusinessRule()
            );

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/admin/departamentos/cadastrar");
                return;
            }

            $newDepartment->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/departamentos/cadastrar");
            return;
        }

        Message::success("Departamento cadastrado com sucesso.");
        redirect("/admin/departamentos/editar/" . $newDepartment->getId());
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_DEPARTMENT);

        $department = Department::find((int)$data["id"]);

        if (!$department) {
            Message::warning("Departamento não encontrado ou não existe.");
            redirect("/admin/departamentos");
            return;
        }

        echo $this->view->render("admin/department/edit", [
            "department" => $department,
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_DEPARTMENT);

        $this->validateCsrfToken($data, "/admin/departamentos/editar/" . $data["id"]);

        $department = Department::find((int)$data["id"]);

        if (!$department) {
            Message::warning("Departamento não encontrado ou não existe.");
            redirect("/admin/departamentos");
            return;
        }

        try {
            $department->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "description" => $data["description"] ?? null,
                "address" => $data["address"] ?? null,
            ]);

            $errors = array_merge(
                $department->validate($data),
                $department->validateBusinessRule($department->getId())
            );

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/admin/departamentos/editar/" . $department->getId());
                return;
            }

            $department->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/departamentos/editar/" . $department->getId());
            return;
        }

        Message::success("Departamento atualizado com sucesso.");
        redirect("/admin/departamentos/editar/" . $department->getId());
    }

    public function destroy(?array $data): void
    {
        Auth::requirePermission(Permission::DELETE_DEPARTMENT);

        $this->validateCsrfToken($data, "/admin/departamentos");

        $department = Department::find((int)$data["id"]);

        if (!$department) {
            Message::error("Departamento não encontrado ou não existe.");
            redirect("/admin/departamentos");
            return;
        }

        if ($department->existsUsers()) {
            Message::warning("Este departamento possui usuários vinculados e não pode ser excluído.");
            redirect("/admin/departamentos");
            return;
        }

        try {
            $department->delete();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/departamentos");
            return;
        }

        Message::success("Departamento excluído com sucesso.");
        redirect("/admin/departamentos");
    }
}