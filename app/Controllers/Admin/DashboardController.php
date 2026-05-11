<?php

namespace App\Controllers\Admin;


use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_MANAGER_DASHBOARD);
    }

    public function index(): void
    {
        $totalUsers = 0;
        $totalDepartments = 0;
        $totalOpenTickets = 0;
        echo $this->view->render("admin/dashboard", [
            "totalUsers" => $totalUsers,
            "totalDepartments" => $totalDepartments,
            "totalOpenTickets" => $totalOpenTickets
        ]);
    }
}