<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Auth\UserProfile;
use App\Models\Department\Department;
use App\Models\Department\UserDepartment;
use App\Models\Role\Role;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::VIEW_USERS);
    }

    public function index(): void
    {
        $users = (new User())->orderBy("name")->get();
        echo $this->view->render("admin/user/index", [
            "users" => $users,
        ]);
        clear_old();
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::CREATE_USER);
        echo $this->view->render("admin/user/create", [
            "roles" => Role::all(),
            "departments" => Department::all(),
        ]);
        clear_old();
    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_USER);
        $this->validateCsrfToken($data, "/admin/usuarios/cadastrar");

        $newUser = new User();

        try {
            $newUser->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "document" => !empty($data["document"]) ? $data["document"] : null,
                "role_id" => $data["role_id"],
                "status" => $data["status"],
            ]);

            $errors = array_merge(
                $newUser->validate($data),
                $newUser->validateBusinessRule()
            );

            $validDepartments = [];
            foreach ($data["departments"] ?? [] as $dept) {
                if (!empty($dept["department_id"])) {
                    $validDepartments[] = $dept;
                }
            }

            if (!empty($validDepartments)) {
                $linkErrors = UserDepartment::validateDepartmentLinks($validDepartments);
                $errors = array_merge($errors, $linkErrors);
            }

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/admin/usuarios/cadastrar");
                return;
            }

            $newUser->save();
            UserProfile::createForUser($newUser->getId());

            if (!empty($validDepartments)) {
                $this->synchronizeDepartmentUser($newUser->getId(), $validDepartments);
            }

        } catch (\InvalidArgumentException $e) {
            Message::error($e->getMessage());
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        Message::success("Usuário cadastrado com sucesso.");
        redirect("/admin/usuarios/editar/" . $newUser->getId());
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_USER);

        $user = User::find((int)$data["id"]);
        if (!$user) {
            Message::warning("Usuário não encontrado ou não existe.");
            redirect("/admin/usuarios");
            return;
        }

        echo $this->view->render("admin/user/edit", [
            "user" => $user,
            "roles" => Role::all(),
            "departments" => Department::all(),
            "userDepartments" => UserDepartment::linksByUser($user->getId()),
        ]);
        clear_old();
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_USER);
        $this->validateCsrfToken($data, "/admin/usuarios/editar/" . $data["id"]);

        $user = User::find((int)$data["id"]);
        if (!$user) {
            Message::warning("Usuário não encontrado ou não existe.");
            redirect("/admin/usuarios");
            return;
        }

        try {
            $user->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "role_id" => $data["role_id"],
                "status" => $data["status"],
            ]);

            if (!empty($data["document"])) {
                $user->setDocument($data["document"]);
            } else {
                $user->setDocument(null);
            }

            if (!empty($data["password"])) {
                $user->setPassword($data["password"]);
            }

            $errors = array_merge(
                $user->validate($data),
                $user->validateBusinessRule($user->getId())
            );

            $validDepartments = [];
            foreach ($data["departments"] ?? [] as $dept) {
                if (!empty($dept["department_id"])) {
                    $validDepartments[] = $dept;
                }
            }

            if (!empty($validDepartments)) {
                $linkErrors = UserDepartment::validateDepartmentLinks($validDepartments);
                $errors = array_merge($errors, $linkErrors);
            }

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/admin/usuarios/editar/" . $user->getId());
                return;
            }

            $user->save();
            $this->removeDepartmentUserLinks($user->getId());

            if (!empty($validDepartments)) {
                $this->synchronizeDepartmentUser($user->getId(), $validDepartments);
            }

        } catch (\InvalidArgumentException $e) {
            Message::error($e->getMessage());
            redirect("/admin/usuarios/editar/" . $user->getId());
            return;
        }

        Message::success("Usuário atualizado com sucesso.");
        redirect("/admin/usuarios/editar/" . $user->getId());
    }

    public function destroy(?array $data): void
    {
        Auth::requirePermission(Permission::DELETE_USER);
        $this->validateCsrfToken($data, "/admin/usuarios");

        $user = User::find((int)$data["id"]);
        if (!$user) {
            Message::error("Usuário não encontrado ou não existe.");
            redirect("/admin/usuarios");
            return;
        }

        if ($user->getId() === Auth::user()->id) {
            Message::warning("Você não pode excluir o próprio usuário.");
            redirect("/admin/usuarios");
            return;
        }

        if ($user->existsDepartmentLinks()) {
            Message::warning("Este usuário possui vínculos com departamentos e não pode ser excluído.");
            redirect("/admin/usuarios");
            return;
        }

        if ($user->existsTickets()) {
            Message::warning("Este usuário possui chamados vinculados e não pode ser excluído.");
            redirect("/admin/usuarios");
            return;
        }

        try {
            $user->delete();
        } catch (\InvalidArgumentException $e) {
            Message::error($e->getMessage());
            redirect("/admin/usuarios");
            return;
        }

        Message::success("Usuário excluído com sucesso.");
        redirect("/admin/usuarios");
    }

    private function synchronizeDepartmentUser(int $userId, array $links): void
    {
        foreach (UserDepartment::validateDepartments($links) as $dept) {
            $newLink = new UserDepartment();
            $newLink->fill([
                "department_id" => $dept["department_id"],
                "user_id" => $userId,
            ]);
            $newLink->save();
        }
    }

    private function removeDepartmentUserLinks(int $userId): void
    {
        foreach (UserDepartment::linksByUser($userId) as $link) {
            $link->delete();
        }
    }
}