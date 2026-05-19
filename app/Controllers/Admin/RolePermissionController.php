<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Role\Permission as PermissionModel;
use App\Models\Role\Role;
use App\Models\Role\RolePermission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::MANAGE_ROLE_PERMISSIONS);
    }

    public function edit(?array $data): void
    {
        $role = Role::find((int)$data["id"]);

        if (!$role) {
            Message::warning("Perfil não encontrado ou não existe.");
            redirect("/admin/perfis");
            return;
        }

        $permissions = (new PermissionModel())->groupedByGroup();
        $currentPermissions = RolePermission::permissionIdsByRole($role->getId());

        echo $this->view->render("admin/role/permissions", [
            "role" => $role,
            "permissions" => $permissions,
            "currentPermissions" => $currentPermissions,
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
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
}