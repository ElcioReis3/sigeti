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


}