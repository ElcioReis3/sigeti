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
        Auth::requirePermission(Permission::VIEW_USERS);
    }

    public function index(): void
    {
        Auth::requirePermission(Permission::VIEW_MANAGER_DASHBOARD);

        $totalUsers = (new User())->totalNumberOfActiveAndRegisteredUsersNotDeleted();
        $totalRoles = (new Role())->totalRoles();
        $totalDepartments = (new Department())->totalDepartments();
        $totalOpenTickets = (new Ticket())->totalTicketsOpened();

        $recentUsers = (new User())->recentlyCreatedActiveRegisteredAndNonDeletedUsers();
        $recentRoles = (new Role())->recentlyCreatedAndNonDeletedRoles();

        echo $this->view->render("admin/dashboard", [
            "totalUsers" => $totalUsers,
            "totalRoles" => $totalRoles,
            "totalDepartments" => $totalDepartments,
            "totalOpenTickets" => $totalOpenTickets,
            "recentRoles" => $recentRoles,
            "recentUsers" => $recentUsers,
        ]);
    }
}