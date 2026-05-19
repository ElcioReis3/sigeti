<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
<<<<<<< HEAD
=======
use App\Models\Role\Permission as PermissionModel;
>>>>>>> 2b3b6a395540462c4eee30aa0810bf7211dfd884
use App\Models\Role\Role;
use App\Models\Role\RolePermission;

class RolePermissionController extends Controller
{
<<<<<<< HEAD

    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_ROLES);
=======
    public function __construct()
    {
        parent::__construct("App");
>>>>>>> 2b3b6a395540462c4eee30aa0810bf7211dfd884
        Auth::requirePermission(Permission::MANAGE_ROLE_PERMISSIONS);
    }

    public function edit(?array $data): void
    {
<<<<<<< HEAD
        Auth::requirePermission(Permission::EDIT_ROLE);
        $role = Role::find($data['id']);
        $permissions = new \App\Models\Role\Permission();

        $currentPermissions = RolePermission::permissionIdsByRole($role->getId());
        $permissions = $permissions->groupedByGroup();

        if (!$role) {
            Message::error("Esse perfil não existe!");
=======
        $role = Role::find((int)$data["id"]);

        if (!$role) {
            Message::warning("Perfil não encontrado ou não existe.");
>>>>>>> 2b3b6a395540462c4eee30aa0810bf7211dfd884
            redirect("/admin/perfis");
            return;
        }

<<<<<<< HEAD

        echo $this->view->render("admin/role/permissions", [
            'role' => $role,
            'permissions' => $permissions,
            'currentPermissions' => $currentPermissions
        ]);
=======
        $permissions = (new PermissionModel())->groupedByGroup();
        $currentPermissions = RolePermission::permissionIdsByRole($role->getId());

        echo $this->view->render("admin/role/permissions", [
            "role" => $role,
            "permissions" => $permissions,
            "currentPermissions" => $currentPermissions,
        ]);

        clear_old();
>>>>>>> 2b3b6a395540462c4eee30aa0810bf7211dfd884
    }

    public function update(?array $data): void
    {
<<<<<<< HEAD
        Auth::requirePermission(Permission::EDIT_ROLE);
        $permissionId = $data["id"];
        $this->validateCsrfToken($data, "/admin/perfis/editar/" . $permissionId . "/permissoes");
        $role = Role::find($data['id']);

        if($role->isProtected()){
            Message::warning("O perfil é protegido e não pode ser alterado!");
            redirect("/admin/perfis/editar/" . $permissionId );
            return;
        }

        $permissionIds = array_map('intval', $data['permissions'] ?? []);

        try {
            if (!$role) {
                Message::error("Esse perfil não existe!");
                redirect("/admin/perfis");
                return;
            }
            RolePermission::syncPermissions($role->getId(), $permissionIds);


        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/perfis/editar/" . $permissionId);
            return;
        }

        Message::success("Permissões atualizada com sucesso!");
        redirect("/admin/perfis/editar/" . $permissionId);

    }


=======
        $this->validateCsrfToken($data, "/admin/perfis/" . $data["id"] . "/permissoes");

        $role = Role::find((int)$data["id"]);

        if (!$role) {
            Message::warning("Perfil não encontrado ou não existe.");
            redirect("/admin/perfis");
            return;
        }

        if ($role->isProtected()) {
            Message::warning("As permissões deste perfil são protegidas e não podem ser alteradas.");
            redirect("/admin/perfis");
            return;
        }

        $permissionIds = array_map('intval', $data["permissions"] ?? []);

        try {
            RolePermission::syncPermissions($role->getId(), $permissionIds);
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/perfis/" . $role->getId() . "/permissoes");
            return;
        }

        Message::success("Permissões atualizadas com sucesso.");
        redirect("/admin/perfis/" . $role->getId() . "/permissoes");
    }
>>>>>>> 2b3b6a395540462c4eee30aa0810bf7211dfd884
}