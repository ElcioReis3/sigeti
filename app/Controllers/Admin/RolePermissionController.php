<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Role\Role;
use App\Models\Role\RolePermission;

class RolePermissionController extends Controller
{

    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_ROLES);
        Auth::requirePermission(Permission::MANAGE_ROLE_PERMISSIONS);
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_ROLE);
        $role = Role::find($data['id']);
        $permissions = new \App\Models\Role\Permission();

        $currentPermissions = RolePermission::permissionIdsByRole($role->getId());
        $permissions = $permissions->groupedByGroup();

        if (!$role) {
            Message::error("Esse perfil não existe!");
            redirect("/admin/perfis");
            return;
        }


        echo $this->view->render("admin/role/permissions", [
            'role' => $role,
            'permissions' => $permissions,
            'currentPermissions' => $currentPermissions
        ]);
    }

    public function update(?array $data): void
    {
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


}