<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Category;
use App\Models\Role\Role;
use App\Models\School;
use App\Models\SchoolUser;
use App\Models\Ticket\Ticket;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_ROLES);
    }

    public function index(): void
    {
        Auth::requirePermission(Permission::VIEW_ROLES);
        $roles = Role::all();

        echo $this->view->render("admin/role/index", [
            'roles' => $roles
        ]);
    }

    public function create(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_ROLE);

        echo $this->view->render("admin/role/create");

    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_ROLE);
        $this->validateCsrfToken($data, "/admin/perfis/cadastrar");

        $role = new Role();

        $payload = [
            'name' => $data['name'],
            'description' => $data['description']
        ];

        $errors = array_merge(
            $role->validate($payload),
        );

        if ($errors) {
            flash_old($data);

            foreach ($errors as $error) {
                Message::warning($error);
            }
            redirect("/admin/perfis/cadastrar");
            return;
        }

        try {

            $role->fill($payload);
            $role->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {

            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/perfis/cadastrar");
            return;
        }

        Message::success("Peril criado com sucesso!.");
        redirect("/admin/perfis/");


        clear_old();
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_ROLE);
        $role = Role::find($data['id']);

        if(!$role){
            Message::warning("Esse Peril não existe!");
            redirect("/admin/perfis");
            return;
        }

        $roles = Role::all();


        echo $this->view->render("admin/role/edit", [
            "roles" => $roles,
            "role" => $role
        ]);

        clear_old();
    }


}