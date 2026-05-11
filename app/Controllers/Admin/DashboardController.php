<?php

namespace App\Controllers\Admin;


use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;
use App\Models\Department\Department;
use App\Models\Role\Role;
use App\Models\Ticket\Ticket;
use App\Models\User;


class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_MANAGER_DASHBOARD);
    }

    public function index(): void
    {
        $totalUsers = User::totalUsers();
        $totalDepartments = Department::totalDepartments();
        $totalOpenTickets = Ticket::totalOpenTickets();
        $recentRegisteredUsers = User::recentRegisteredUsers();
        $totalRoles = Role::totalRoles();
        $roles = Role::all();
        $recentUsers = User::recentUsers();


        echo $this->view->render("admin/dashboard", [
            "totalUsers" => $totalUsers,
            "totalDepartments" => $totalDepartments,
            "totalOpenTickets" => $totalOpenTickets,
            "totalRoles" => $totalRoles,
            "roles" => $roles,
            "recentUsers" => $recentUsers,
            "recentRegisteredUsers" => $recentRegisteredUsers,
        ]);
    }
}